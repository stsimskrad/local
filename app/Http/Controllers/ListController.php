<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Scholar;
use App\Models\SchoolCampus;
use App\Models\Dropdown;
use App\Models\Expense;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\LocationBarangay;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\School\SearchResource;
use App\Http\Resources\ViewResource;

class ListController extends Controller
{
    public function index(){
        $datas = [
            'dropdowns' => $this->dropdowns(),
            'regions' => $this->regions(),
            'profile' => $this->profile(),
            'expenses' => $this->expenses()
        ];

        return $datas;
    }

    public function profile()
    {   
        if(\Auth::user()->role == 'Scholar'){
            $data = User::with('scholar.scholar.status','scholar.scholar.category')->where('id',\Auth::id())->first();
        }else{
            $data = User::with('profile')->where('id',\Auth::id())->first();
        }
        return new ViewResource($data);
    }

    public function dropdowns(){
        $data = Dropdown::all();
        return DefaultResource::collection($data);
    }

    public function expenses(){
        $data = Expense::all();
        return DefaultResource::collection($data);
    }

    public function regions()
    {
        $data = LocationRegion::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function provinces($id = null)
    {
        $data = LocationProvince::where('region_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function municipalities($id = null)
    {
        $data = LocationMunicipality::where('province_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function barangays($id = null)
    {
        $data = LocationBarangay::where('municipality_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function schools(Request $request){

        $keyword = $request->input('word');
        $data = SchoolCampus::with('school')
        ->whereHas('school',function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhere(function ($query) use ($keyword) {
            $query->where('campus',$keyword);
        })->get()->take(10);

        return SearchResource::collection($data);
    }

    public function courses(Request $request){
        $keyword = $request->input('word');
        $data = Course::where('name','LIKE','%'.$keyword.'%')->get()->take(10);
        return DefaultResource::collection($data);
    }

    public function scholars(Request $request){
        $keyword = $request->input('word');
        $data = Scholar::with('profile')
        ->whereHas('profile',function ($query) use ($keyword) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%');
        })->get()->take(5);
        return DefaultResource::collection($data);
    }
}
