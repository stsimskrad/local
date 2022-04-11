<?php

namespace App\Http\Controllers\Scholar;

use Hashids\Hashids;
use App\Models\Prospectus;
use App\Models\Profile;
use App\Models\Qualifier;
use App\Models\Scholar;
use App\Models\ScholarAddress;
use App\Models\ScholarSchool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\StatusTrait;
use App\Http\Resources\Scholar\IndexResource;
use App\Http\Resources\Scholar\SearchResource;
use App\Http\Resources\Scholar\ListsResource;
use App\Http\Requests\ScholarRequest;

class IndexController extends Controller
{
    use StatusTrait;

    public function lists($status,$category,$count,$year,$keyword,$array,$array2)
    {
        $location = (!empty(json_decode($array))) ? json_decode($array) : NULL;
        $education = (!empty(json_decode($array2))) ? json_decode($array2) : NULL;

        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = Scholar::with('profile')->with('address.municipality.province.region')->with('school.school.school','school.course')
        ->whereHas('profile',function ($query) use ($keyword) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
        })
        ->whereHas('address',function ($query) use ($location) {
           if(!empty($location)){
                (property_exists($location, 'region')) ? $query->where('region_code',$location->region) : '';
                (property_exists($location, 'province')) ? $query->where('province_code',$location->province) : '';
                (property_exists($location, 'municipality')) ? $query->where('municipality_code',$location->municipality) : '';
                (property_exists($location, 'barangay')) ? $query->where('barangay_code',$location->barangay) : '';
           }
        })
        ->whereHas('school',function ($query) use ($education) {
            if(!empty($education)){
                (property_exists($education, 'school')) ? $query->where('school_id',$education->school) : '';
                (property_exists($education, 'course')) ? $query->where('course_id',$education->course) : '';
            }
         })
        ->where(function ($query) use ($category,$status,$year) {
            ($category == '-') ? '' : $query->where('category_id',$category);
            ($status == '-') ? '' : $query->where('status_id',$status);
            ($year == '-') ? '' : $query->where('awarded_year',$year);
        })
        ->orderBy('awarded_year','DESC')->orderBy('id','DESC')->paginate($count);
        return ListsResource::collection($data);
    }

    public function store(ScholarRequest $request)
    {
        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = Scholar::with('profile')->with('school.school')->where('id',$request->id)->first();
                $data->update($request->except('editable'));
                // dd($data);
                ($request->status_id) ? $this->storeStatus($request) : '';
                if($request->type == 'old'){
                    $data->school()->update($request->except('editable','is_completed','type'));
                    $data = Scholar::with('profile')->with('address.municipality.province.region')->with('school.school.school','school.course')->where('id',$request->id)->first();
                }
                // $profile = Profile::where('scholar_id',$request->id)->first();
                // $profile->update($request->except('email','img','editable'));
                return $data;
            }elseif($request->editable == "new"){
                $parents = [
                    'mother' => $request->mother,
                    'father' => $request->father,
                ];

                $information = [
                    'birth_place' => 'n/a',
                    'course' => 'n/a',
                    'school' => 'n/a',
                    'address' => 'n/a',
                    'parents' => $parents
                ];
                $data = Profile::create(array_merge($request->all(),['information' => json_encode($information)]));
                $test = $data->scholar()->create(array_merge($request->all(), ['awarded_year' => '2022']));
                $test->address()->create(array_merge($request->all(), ['type' => 'original']));
                $data = Scholar::findOrFail($test->id);
                return $data;
            }elseif($request->editable == "address"){
                $data = ScholarAddress::where('scholar_id',$request->scholar_id)->first();
                $data->update($request->except('editable'));
                $data = Scholar::with('profile')->with('school.school')->where('id',$request->scholar_id)->first();
                return $data;
            }else{
                $info = [];
                $data = Scholar::create($request->all());
                $data->address()->create(array_merge($request->all(), ['type' => 'original']));
                $data->school()->create(['information' => json_encode($info)]);
                if($data){
                    $wee = Qualifier::where('id',$request->qualifier_id)->update(['is_qualified' => 1]);
                    return $data;
                }
            }
        });
        return new ListsResource($data);
    }

    public function view($id)
    {
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = Scholar::with('profile','school.school','address.region','address.province','address.municipality','address.barangay')->where('id',$id)->first();
        return new IndexResource($data);
    }  

    public function filter($status,$school,$year,$level,$keyword)
    {
        $query = Scholar::query();
        $query = $query->with('profile')->with('status')->with('school.school.school','school.course');
        if($keyword != '-'){
            $query->whereHas('profile',function ($query) use ($keyword) {
                $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
            });
            $data = $query->paginate(1);
        }else{
            $query->where(function ($query) use ($status,$year) {
                ($year == '-') ? '' : $query->where('awarded_year',$year);
                ($status == '-') ? '' : $query->where('status_id',$status);
            });
            $query->whereHas('school',function ($query) use ($school,$level) {
                ($school == '-') ? '' : $query->where('school_id',$school);
                ($level == '-') ? '' : $query->where('level_id',$level);
                $query->where('course_id','!=',NULL);
            });
            $data = $query->orderBy('id','DESC')->get();
        }
        return SearchResource::collection($data);
    }

    public function status(Request $request){
        $data = Scholar::whereIn('id',$request->selected)->update(['status_id' => $request->status_id]);
        if($data){
            $this->storeStatus($request);
        }
        return $data;
    }

    public function subcourse(Request $request){
        $data = ScholarSchool::where('scholar_id',$request->id)->first();

        $pros = Prospectus::where('school_course_id',$request->subcourse_id)->first();
        $information = [
            'prospectus' => json_decode($pros->subjects)
        ];
        $data->subcourse_id = $request->subcourse_id;
        $data->information = json_encode($information);
        if($data->save()){
            $data = Scholar::with('profile')->with('school.school')->with('enrollments')->with('course.lists')->with('subcourse.subcourse')
            ->where('id',$request->id)
            ->first();
            return new GradingResource($data);
        }   
    }
}
