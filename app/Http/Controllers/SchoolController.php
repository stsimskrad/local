<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Models\SchoolCampus;
use App\Models\SchoolCourse;
use App\Models\SchoolSemester;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\SemesterRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\School\ViewResource;
use App\Http\Resources\School\CourseResource;

class SchoolController extends Controller
{
    public function lists($keyword,$count){
        ($keyword == '-') ? $keyword = '' : $keyword;
        $data = SchoolCampus::with('school')
        ->whereHas('school',function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhere(function ($query) use ($keyword) {
            $query->where('campus', 'LIKE', '%'.$keyword.'%');
        })->paginate($count);
        return ViewResource::collection($data);
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = SchoolCampus::with('school')->with('courses.course','courses.prospectuses')->with('semesters.semester')->where('id',$id[0])->first();
        return new ViewResource($data);
    }

    public function course(CourseRequest $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = SchoolCourse::where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = SchoolCourse::create($request->all());
                return $data;
            }
        });
        return new CourseResource($data);
    }

    public function semester(SemesterRequest $request){
        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = SchoolSemester::where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $data = SchoolSemester::create($request->all());
                return $data;
            }
        });
        return new DefaultResource($data);
    }

    public function semesteryear($id,$year){
        $data = SchoolSemester::with('semester')->where('school_id',$id)->whereYear('start_at', '>=' ,$year)->orderBy('id','DESC')->get();
        return $data;
    }

    public function subcourses($school,$course){
        $data = SchoolCourse::where('school_id',$school)->where('course_id',$course)->get();
        return $data;
    }
}
