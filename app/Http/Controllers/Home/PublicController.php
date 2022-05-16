<?php

namespace App\Http\Controllers\Home;

use App\Models\Scholar;
use App\Models\ListProgram;
use App\Models\LocationProvince;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){

        $array = [
            'provinces' => $this->provinces(),
            'programs' => $this->programs(),
        ];

        return $array;
    }

    public function provinces(){
        $provinces = ['097200000','097300000','098300000','099300000'];
        $provinces = LocationProvince::whereIn('code',$provinces)->get();
        $programs = ListProgram::all();

        $array = []; $sums = []; $total = [];
        
        foreach($provinces as $key=>$province){
            $code = $province->code;
            $count = [];
            foreach($programs as $key2=>$program){
                $data = Scholar::whereHas('address',function ($query) use ($code) {
                    $query->where('province_code',$code);
                })->where('program_id',$program->id)->count();
                array_push($count,$data);    
                $sums[$key2][$key] = $data;
            }

            $array[] = [
                'province' => $province,
                'count' => $count
            ];
        }

        foreach($programs as $key2=>$program){
            $total[] = array_sum($sums[$key2]); 
        }
        
        $all = [
            'provinces' => $array,
            'totals' => $total,
            'programs' => $programs
        ];

        return $all;
    }

    public function programs(){
        $undergrad = ListProgram::withCount(['scholar'=> function($q){
            $q->where('is_undergrad',1);
        }])->get();

        $jlss = ListProgram::withCount(['scholar'=> function($q){
            $q->where('is_undergrad',0);
        }])->get();

        return $data = [
            'undergrad' => $undergrad,
            'jlss' => $jlss
        ];
    }

}
