<?php

namespace App\Http\Controllers\Home;

use App\Models\User;
use App\Models\Scholar;
use App\Models\FinancialGroup;
use App\Models\ListProgram;
use App\Models\ListCourse;
use App\Models\SchoolCampus;
use App\Models\LocationProvince;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class CoordinatorController extends Controller
{   
    public function index(){

        $array = [
            'staffs' => $this->staffs(),
            'provinces' => $this->provinces(),
            'academic_year' => $this->academicyear(),
            'schools' => $this->schools(),
            'courses' => $this->courses()
        ];

        return $array;
    }

    public function schools(){
        $data = SchoolCampus::with('school')->withCount('scholars')->orderBy('scholars_count', 'desc')->take(5)->get();
        return $data;
    }

    public function courses(){
        $data = ListCourse::withCount('scholars')->orderBy('scholars_count', 'desc')->take(5)->get();
        return $data;
    }

    public function academicyear(){
        $data = FinancialGroup::with('semester')->where('is_active',1)->first();
        return $data;
    }

    public function staffs(){
        $data = User::with('profile')->whereIn('role',['Regional Director','Scholarship Coordinator'])->get();
        return UserResource::collection($data);
    }

    public function provinces(){
        $provinces = ['097200000','097300000','098300000','099300000'];
        $provinces = LocationProvince::whereIn('code',$provinces)->get();
        $programs = ListProgram::where('is_sub',0)->get();

        $array = [];
        
        foreach($provinces as $province){
            $code = $province->code;
            $count = [];
            foreach($programs as $program){
                $data = Scholar::whereHas('address',function ($query) use ($code) {
                    $query->where('province_code',$code);
                })->where('program_id',$program->id)->count();
                array_push($count,$data);
            }

            $array[] = [
                'province' => $province,
                'count' => $count
            ];
        }
        $all = [
            'provinces' => $array,
            'programs' => $programs
        ];

        return $all;
    }
}
