<?php

namespace App\Http\Traits;

use App\Models\Scholar;
use App\Models\Prospectus;
use App\Models\ScholarSchool;
use App\Models\ScholarEnrollmentList;
use App\Http\Resources\DefaultResource;

trait EnrollmentTrait {
    
    public function createList($id,$request) 
    {
        $lists = $request->lists;
        foreach($lists as $key=>$list){
            $options = [];
            ScholarEnrollmentList::create(array_merge($list,[
                'options' => json_encode($options) ,
                'enrollment_id' => $id,
                'encoded_by' =>  \Auth::user()->id
            ]));
        }
    }

    public function check($request)
    {
        $count = ScholarCourse::where('scholar_id',$request->scholar_id)->count();
        if($count == 0){
            $pros = Prospectus::where('school_course_id',$request->subcourse)->first();
            $information = [
                'prospectus' => json_decode($pros->subjects)
            ];

            $data = new ScholarCourse;
            $data->scholar_id = $request->scholar_id;
            $data->subcourse_id = $request->subcourse;
            $data->information = json_encode($information);
            $data->save();
        }
    }

    public function level($request){
        $data = ScholarSchool::where('scholar_id',$request->scholar_id)->first();
        ($data->level_id != $request->level_id) ? $data->level_id = $request->level_id : '';
        $data->save();
    }
}