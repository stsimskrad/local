<?php

namespace App\Http\Controllers\Insight;

use App\Models\Qualifier;
use App\Models\Scholar;
use App\Models\ScholarEducation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $arr = []; 

        array_push($arr,$this->scholars());
        array_push($arr,$this->qualifiers());
        array_push($arr,$this->graduates());
        return $arr;
    }

    public function scholars(){
        $array = [];
        $data = Scholar::select('awarded_year AS x',\DB::raw('count(*) AS y'))
        ->orderBy('awarded_year')->groupBy('awarded_year')->get();

        $arr = [
            'name' => 'Scholars',
            'data' => $data
        ];
        array_push($array,$arr);

        return $arr = [
            'name' => 'Scholars',
            'icon' => 'bxs-user-circle',
            'color' => 'danger',
            'series' => $array,
            'total' => Scholar::count(),
        ];
    }

    public function qualifiers(){
        $array = [];
        $data = Qualifier::select('year AS x',\DB::raw('count(*) AS y'))
        ->orderBy('year')->groupBy('year')->get();

        $arr = [
            'name' => 'Qualifiers',
            'data' => $data
        ];
        array_push($array,$arr);
        
        return $arr = [
            'name' => 'Qualifiers',
            'icon' => 'bx-notepad',
            'color' => 'primary',
            'series' => $array,
            'total' => Qualifier::count(),
        ];
    }

    public function graduates(){
        $array = [];
        $data = ScholarEducation::select('graduated_year AS x',\DB::raw('count(*) AS y'))
        ->whereNotNull('graduated_year')
        ->orderBy('graduated_year')->groupBy('graduated_year')->get();

        $arr = [
            'name' => 'Graduates',
            'data' => $data
        ];
        array_push($array,$arr);
        
        return $arr = [
            'name' => 'Graduates',
            'icon' => 'bxs-graduation',
            'color' => 'success',
            'series' => $array,
            'total' => ScholarEducation::whereNotNull('graduated_year')->count(),
        ];
    }
}
