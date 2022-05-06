<?php

namespace App\Http\Controllers\Scholar;

use App\Models\Scholar;
use App\Models\ScholarEducation;
use App\Models\ScholarAddress;
use App\Http\Controllers\Controller;
use App\Http\Resources\Scholar\EducationResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        $scholar_id = \Auth::user()->scholar->scholar->id;
        $datas = [
            'address' => $this->address($scholar_id),
            'education' => $this->school($scholar_id),
        ];
        return $datas;
    }

    public function address($id){
        $data = ScholarAddress::with('region')->with('province')
        ->with('municipality')->with('barangay')
        ->where('scholar_id',$id)->first();
        return $data;
    }

    public function school($id){
        $data = ScholarEducation::with('school.school')
        ->where('id',$id)->first();
        return new EducationResource($data);
    }
}
