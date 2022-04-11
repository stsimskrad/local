<?php

namespace App\Http\Controllers\Evaluation;

use App\Models\ScholarSchool;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Evaluation\EnrollmentResource;

class GradeController extends Controller
{
    public function store(Request $request)
    {
        $count = 0;
        foreach($request->lists as $list){
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
            $p = ScholarSchool::with('subcourse')->where('scholar_id',$data->scholar_id)->first();
            $years = $p->subcourse->years; 
            $semesters = 3;

            $prospectus = json_decode($p->information,true);

            for($x = 0; $x < $years; $x++){
                for($y = 0; $y < $semesters; $y++){
                    foreach($request->lists as $list){
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
