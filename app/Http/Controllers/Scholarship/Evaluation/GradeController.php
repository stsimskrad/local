<?php

namespace App\Http\Controllers\Scholarship\Evaluation;

use App\Models\ScholarEducation;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Evaluation\EnrollmentResource;
use App\Http\Requests\GradeRequest;
use App\Http\Traits\EnrollmentUpload;

class GradeController extends Controller
{
    use EnrollmentUpload;

    public function store(GradeRequest $request)
    {      
        $enrollment = ScholarEnrollment::where('id',$request->enrollment_id)->first();
        $attach = json_decode($enrollment->attachment,true);
        array_push($attach['grades'],$this->grade($request,$enrollment));
        $enrollment->attachment = $attach;
        $enrollment->save();

        $count = 0;
        $subjects = json_decode($request->lists,true);
        foreach($subjects as $list){
            $enrollment_id = $list['enrollment_id'];
            ($list['grade'] == null) ? $count++ : '';
            $data = ScholarEnrollmentList::where('id',$list['id'])->first();
            $data->grade = $list['grade'];
            $data->is_failed = ($list['grade']== 'F' || $list['grade'] == 5) ? 1 : 0;
            if($data->isDirty('grade')){
                $data->encoded_by = \Auth::user()->id;
            }
            $data->save();
        }

        $data = ScholarEnrollment::where('id',$enrollment_id)->first();
        ($count == 0) ? $data->is_clear = 1 : $data->is_clear = 0;

        if($data->save()){
            $p = ScholarEducation::with('subcourse')->where('scholar_id',$data->scholar_id)->first();
            $years = $p->subcourse->years; 
            $semesters = 3;

            $prospectus = json_decode($p->information,true);

            for($x = 0; $x < $years; $x++){
                for($y = 0; $y < $semesters; $y++){
                    foreach(json_decode($request->lists,true) as $list){
                        $code = $list['code']; $is_lab = $list['is_lab'];
                        $results = array_filter($prospectus['prospectus'][$x]['semesters'][$y]['courses'], function($people) use ($code,$is_lab) {
                            if(array_key_exists("code",$people)){
                                return $people['code'] == $code && $people['is_lab'] == $is_lab;
                            }else{
                                return $results = [];
                            }
                        });

                        if(!empty($results)){
                            $key = array_keys($results)[0];
                            ($list['grade'] == 'F' || $list['grade'] == 'f' || $list['grade'] == 5) ? $failed = 1 : $failed = 0;
                            // dd(array_key_exists("is_failed",$prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]));
                            if(array_key_exists("is_failed",$prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key])){
                                if($prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['is_failed']){
                                    $grades = $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grades'];
                                    array_push($grades,strtoupper($list['grade']));
                                    $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grades'] = $grades;
                                }
                            }else{
                                if($failed){
                                    $grades = [];
                                    array_push($grades,strtoupper($list['grade']));
                                    $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grades'] = $grades;
                                }else{
                                    $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grade'] = $list['grade'];
                                }
                            }
                            $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['is_failed'] = $failed;
                        }
                    }
                }
            }

            $p->information = $prospectus;
            $p->save();   
        }
        return new EnrollmentResource($data);
    }
}
