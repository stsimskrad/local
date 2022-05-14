<?php

namespace App\Http\Controllers\Home;

use App\Models\User;
use App\Models\Scholar;
use App\Models\ScholarEnrollment;
use App\Models\Qualifier;
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
            'academic_year' => $this->academicyear(),
            'schools' => $this->schools(),
            'courses' => $this->courses(),
            'qualifiers' => $this->qualifiers()
        ];

        return $array;
    }

    public function qualifiers(){
        $undegrad = Qualifier::where('is_undergrad',1)->where('is_qualified',NULL)->count();
        $jlss = Qualifier::where('is_undergrad',0)->where('is_qualified',NULL)->count();
        return $data = [
            'Undergraduate' => $undegrad,
            'JLSS' => $jlss
        ];
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
        $group = FinancialGroup::with('semester')->where('is_active',1)->first();

        $academic_year = $group->academic_year;
        $semester_id = $group->semester_id;

        $enrolled = ScholarEnrollment::whereHas('semester',function ($query) use ($academic_year,$semester_id) {
            $query->where('academic_year',$academic_year)->where('semester_id',$semester_id);
        })->count();

        $ongoing = Scholar::whereHas('status',function ($query){
            $query->where('type','ongoing');
        })->count();


        $data = [
            'group' => $group,
            'enrolled' => $enrolled,
            'ongoing' => $ongoing
        ];

        return $data;
    }

    public function staffs(){
        $data = User::with('profile')->whereIn('role',['Regional Director','Scholarship Coordinator'])->get();
        return UserResource::collection($data);
    }
}
