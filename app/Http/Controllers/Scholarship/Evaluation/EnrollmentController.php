<?php

namespace App\Http\Controllers\Scholarship\Evaluation;

use App\Models\Scholar;
use App\Models\ScholarEducation;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\EnrollmentTrait;
use App\Http\Traits\EnrollmentUpload;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Evaluation\GradingResource;
use App\Http\Resources\Evaluation\SubjectResource;
use App\Http\Resources\Scholarship\Sub\EnrollmentResource;
use App\Http\Requests\EnrollmentRequest;
use Hashids\Hashids;  

class EnrollmentController extends Controller
{
    use EnrollmentTrait, EnrollmentUpload;

    public function lists($id){
        $data = ScholarEnrollmentList::where('enrollment_id',$id)->get();
        return SubjectResource::collection($data);
    }

    public function index($id,$keyword){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $query = ScholarEnrollment::query()->where('scholar_id',$id);
        ($keyword == '-') ? $keyword = '' : $keyword;
        if($keyword != ''){
            $query->whereHas('semester',function ($query) use ($keyword) {
                $query->where('academic_year', 'LIKE', '%'.$keyword.'%');
            });
        }

        $data = $query->orderBy('created_at','DESC')->paginate(5);
        return EnrollmentResource::collection($data);
    }

    public function store(EnrollmentRequest $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = ScholarEnrollment::where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $hashids = new Hashids('krad',10);
                $scholar_id = $hashids->decode($request->scholar_id);

                $this->financialGroup($request);
               
                $attachments = [
                    'grades' => [],
                    'enrollments' => $this->enrollment($request)
                ];
                
                $data = ScholarEnrollment::create(array_merge($request->all(),['scholar_id' => $scholar_id[0],'attachment' => json_encode($attachments), 'added_by' => \Auth::user()->id]));
                $this->level($request);
                $this->createList($data->id,$request);
                $data = ScholarEnrollment::find($data->id);
                return $data;
            }
        });
        return new EnrollmentResource($data);
    }

    public function switch(Request $request){
        
        $from = $request->from;
        $to = $request->to;
        $p = ScholarEducation::with('subcourse')->where('scholar_id',$request->scholar_id)->first();
        $years = $p->subcourse->years; 
        $semesters = 3;
        $prospectus = json_decode($p->information,true);
    
        for($x = 0; $x < $years; $x++){
            for($y = 0; $y < $semesters; $y++){
                $result = array_filter($prospectus['prospectus'][$x]['semesters'][$y]['courses'], function($all) use ($from) {
                    return $all['code'] == $from['code'];
                });
                if(!empty($result)){
                    for($z = 0; $z < $years; $z++){
                        for($w = 0; $w < $semesters; $w++){
                            $result2 = array_filter($prospectus['prospectus'][$z]['semesters'][$w]['courses'], function($all) use ($to) {
                                return $all['code'] == $to['code'] && $all['is_lab'] == $to['is_lab'];
                            });
                            if(!empty($result2)){
                                $key = array_keys($result)[0];
                                $key2 = array_keys($result2)[0];
                                $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key] = $result2[$key2];
                                $prospectus['prospectus'][$z]['semesters'][$w]['courses'][$key2] = $result[$key];
                                break;
                            }
                        }
                    }
                    break;
                }
            }
        }
        $p->information = $prospectus;
        $p->save();   

        return new DefaultResource($p);
    }
}
