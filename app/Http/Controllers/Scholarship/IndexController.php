<?php

namespace App\Http\Controllers\Scholarship;

use App\Models\Scholar;
use App\Imports\ScholarImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ScholarTrait;
use App\Http\Requests\ScholarRequest;
use App\Http\Resources\Scholarship\IndexResource;
use App\Http\Resources\Scholarship\SearchResource;
use App\Http\Resources\Scholarship\EvaluationResource;
use Hashids\Hashids; 

class IndexController extends Controller
{
    use ScholarTrait;

    public function lists(Request $request){

        $info = (!empty(json_decode($request->info))) ? json_decode($request->info) : NULL;
        $education = (!empty(json_decode($request->education))) ? json_decode($request->education) : NULL;
        $location = (!empty(json_decode($request->location))) ? json_decode($request->location) : NULL;
        
        $data = Scholar::with('profile.user')
        ->with('address.municipality.province.region')
        ->with('education.school.school','education.course')
        ->whereHas('profile',function ($query) use ($info) {
            ($info->keyword == '-') ? '' : $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$info->keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$info->keyword.'%');;
        })
        ->whereHas('address',function ($query) use ($location) {
           if(!empty($location)){
                (property_exists($location, 'region')) ? $query->where('region_code',$location->region) : '';
                (property_exists($location, 'province')) ? $query->where('province_code',$location->province) : '';
                (property_exists($location, 'municipality')) ? $query->where('municipality_code',$location->municipality) : '';
                (property_exists($location, 'barangay')) ? $query->where('barangay_code',$location->barangay) : '';
           }
        })
        ->whereHas('education',function ($query) use ($education) {
            if(!empty($education)){
                (property_exists($education, 'school')) ? $query->where('school_id',$education->school) : '';
                (property_exists($education, 'course')) ? $query->where('course_id',$education->course) : '';
            }
         })
        ->where(function ($query) use ($info) {
            ($info->program == null) ? '' : $query->where('program_id',$info->program);
            ($info->status == null) ? '' : $query->where('status_id',$info->status);
            ($info->is_undergrad == 'all') ? '' : $query->where('is_undergrad',$info->is_undergrad);
            ($info->year == null) ? '' : $query->where('awarded_year',$info->year);
        })
        ->orderBy('awarded_year','DESC')->orderBy('id','DESC')->paginate($info->counts);
        return IndexResource::collection($data);
    }

    public function store(ScholarRequest $request){
        $data = \DB::transaction(function () use ($request){
            switch($request->editable){
                case 'single': 
                    return $this->single($request);
                break;
                case 'qualifier': 
                    return $this->qualifier($request);
                break;
                case 'course': 
                    return $this->course($request);
                break;
                case 'true': 
                    return $this->true($request);
                break;
            }
        });
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = Scholar::with('profile','education.school','address.region','address.province','address.municipality','address.barangay')->where('id',$id)->first();
        return new IndexResource($data);
    }  

    public function filter($info){
        $info = (!empty(json_decode($info))) ? json_decode($info) : NULL;
        $query = Scholar::query();
        $query = $query->with('profile')->with('status')->with('education.school.school','education.course');
        if($info->keyword != '-'){
            $query->whereHas('profile',function ($query) use ($info) {
                $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$info->keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$info->keyword.'%');
            });
            $data = $query->paginate(1);
        }else{
            $query->where(function ($query) use ($info) {
                ($info->year == '-') ? '' : $query->where('awarded_year',$info->year);
                ($info->status == '-') ? '' : $query->where('status_id',$info->status);
            });
            $query->whereHas('education',function ($query) use ($info) {
                ($info->school == '-') ? '' : $query->where('school_id',$info->school);
                ($info->level == '-') ? '' : $query->where('level_id',$info->level);
                $query->where('course_id','!=',NULL);
            });
            $data = $query->orderBy('id','DESC')->get();
        }
        return SearchResource::collection($data);
    }

    public function search($keyword){
        $data = Scholar::with('profile')->with('status')->with('education.school.school','education.course','education.level')->with('enrollments')
        ->whereHas('profile',function ($query) use ($keyword) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
        })->first();
        return new EvaluationResource($data);
    }
}
