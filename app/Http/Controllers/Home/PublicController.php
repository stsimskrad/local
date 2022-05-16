<?php

namespace App\Http\Controllers\Home;

use App\Models\Scholar;
use App\Models\ScholarAddress;
use App\Models\ListProgram;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
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

        $provinces = ScholarAddress::groupBy('province_code')->pluck('province_code');
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
                'count' => $count,
                'total' => array_sum($count)
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

    public function lists(){
        $province = '097200000';

        $data = LocationMunicipality::select('province_code','district')->withCount('scholars')->where('province_code',$province)->groupBy('district')->get();
        // return $data;   
        
        $data = ScholarAddress::where('province_code',$province)->count();
        return $data;
    }

    public function totals(){
        $total = Scholar::count();
        $graduates = Scholar::where('status_id',36)->count();
        $ongoing = Scholar::whereIn('status_id',[31,32,33,34,35])->count();

        $array = [
            ['counts' => $total, 'name' => 'Total Scholars', 'icon' => 'bx-group', 'color' => 'success'],
            ['counts' => $graduates,'name' => 'Total Graduates', 'icon' => 'bxs-graduation', 'color' => 'info'],
            ['counts' => $ongoing,'name' => 'Ongoing Scholars', 'icon' => 'bx-user-circle', 'color' => 'primary']
        ];

        return $array;
    }

}
