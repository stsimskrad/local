<?php

namespace App\Http\Controllers\Insight;

use App\Models\Qualifier;
use App\Models\School;
use App\Models\Scholar;
use App\Models\ListProgram;
use App\Models\ListCourse;
use App\Models\ListAgency;
use App\Models\LocationProvince;
use App\Models\SchoolCampus;
use App\Models\ScholarAddress;
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
        
        return $a = [
            'arr' => $arr,
            'types' => $this->types(),
            'schools' => $this->schools(),
            'courses' => $this->courses(),
            'total' => Scholar::count()
        ];
    }

    public function scholars(){
        $array = [];
        $data = Scholar::select('awarded_year AS x',\DB::raw('count(*) AS y'))
        ->orderBy('awarded_year')->groupBy('awarded_year')->get();
        $len = count($data);
        
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
            'number' => ($len != 0) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => Scholar::count(),
        ];
    }

    public function qualifiers(){
        $array = [];
        $data = Qualifier::select('year AS x',\DB::raw('count(*) AS y'))
        ->orderBy('year')->groupBy('year')->get();
        $len = count($data);

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
            'number' =>  ($len != 0 && $len != 1) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0 && $len != 1) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => Qualifier::count(),
        ];
    }

    public function graduates(){
        $array = [];
        $data = ScholarEducation::select('graduated_year AS x',\DB::raw('count(*) AS y'))
        ->whereNotNull('graduated_year')
        ->orderBy('graduated_year')->groupBy('graduated_year')->get();
        $len = count($data);

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
            'number' =>  ($len != 0) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => ScholarEducation::whereNotNull('graduated_year')->count(),
        ];
    }

    public function types(){
        $agency_id = config('app.agency');
        $agency = ListAgency::with('region')->where('id',$agency_id)->first();
        $region_code = $agency->region_code;

        $undegrad = Scholar::where('is_undergrad',1)->count();
        $jlss = Scholar::where('is_undergrad',0)->count();
        $lists = ListProgram::withCount('scholar')->get();
        $male = Scholar::whereHas('profile',function ($query){
            $query->where('gender',1);
        })->count();
        $female = Scholar::whereHas('profile',function ($query){
            $query->where('gender',2);
        })->count();
        $gender = [$male,$female];
        $schools = [
            $private = School::where('class_id',7)->whereHas('campuses',function ($query) use ($region_code){
                $query->whereHas('municipality',function ($query) use ($region_code){
                    $query->whereHas('province',function ($query) use ($region_code){
                        $query->whereHas('region',function ($query) use ($region_code){
                            $query->where('code',$region_code);
                        });
                    });
                });
            })->count(),
            $public = School::where('class_id',8)->whereHas('campuses',function ($query) use ($region_code){
                $query->whereHas('municipality',function ($query) use ($region_code){
                    $query->whereHas('province',function ($query) use ($region_code){
                        $query->whereHas('region',function ($query) use ($region_code){
                            $query->where('code',$region_code);
                        });
                    });
                });
            })->count(),
            $private + $public
        ];

        return $data = [
            'Undergraduate' => $undegrad,
            'JLSS' => $jlss,
            'total' => $undegrad+$jlss,
            'lists' => $lists,
            'gender' => $gender,
            'schools' => $schools
        ];
    }

    public function years(Request $request){
        $provinces = ScholarAddress::groupBy('province_code')->pluck('province_code');
        $programs = ListProgram::all();
        $year = 1994; $current_year =  date('Y'); $years = [];
        $province = ($request->province) ? $request->province : null;
        $is_undergrad = ($request->is_undergrad != null) ? $request->is_undergrad : null;
        $pro = ($request->program) ? $request->program : null;


        $prog = []; 
        foreach($programs as $program){
            $data = []; $year = 1994;
            for($year; $year <= $current_year; $year++ ){
                $years[] = $year;
                $data[] = ListProgram::where('id',$program->id)->withCount([
                'scholar', 
                'scholar as scholar_count' => function ($query) use ($year,$province,$is_undergrad,$pro){
                    $query->where('awarded_year', $year)
                    ->whereHas('address',function ($query) use ($province,$pro) {
                        ($province != null) ? $query->where('province_code', $province) : '';
                    });
                    ($is_undergrad != null) ? $query->where('is_undergrad', $is_undergrad) : '';
                    ($pro != null) ? $query->where('program_id', $pro) : '';
                }])->pluck('scholar_count')->first();
            }
            $arr[] = [
                'name' => $program->name,
                'data' => $data  
            ];
            
        }

        return $y =[
            'categories' => $years,
            'programs' => $programs,
            'provinces' => LocationProvince::whereIn('code',$provinces)->get(),
            'lists' => $arr
        ];


        // foreach($programs as $program){
        //     $data = []; $year = 1994;
        //     foreach($provinces as $province){
        //         $data[] = ListProgram::where('id',$program->id)->withCount([
        //         'scholar', 
        //         'scholar as scholar_count' => function ($query) use ($province,$is_undergrad,$program){
        //             $query->whereHas('address',function ($query) use ($province,$program) {
        //                $query->where('province_code', $province);
        //             });
        //             ($is_undergrad != null) ? $query->where('is_undergrad', $is_undergrad) : '';
        //             ($program != null) ? $query->where('program_id', $program->id) : '';
        //         }])->pluck('scholar_count')->first();
        //     }
        //     $arr[] = [
        //         'name' => $program->name,
        //         'data' => $data  
        //     ];
        // }

        // return $y =[
        //     'categories' =>  LocationProvince::whereIn('code',$provinces)->pluck('name'),
        //     'programs' => $programs,
        //     'lists' => $arr
        // ];


        // for($year; $year <= $current_year; $year++ ){
        //     $prog = []; $years[] = $year;
        //     foreach($programs as $program){
        //         $data = ListProgram::where('id',$program->id)->withCount([
        //             'scholar', 
        //             'scholar as scholar_count' => function ($query) use ($year){
        //                 $query->where('awarded_year', $year);
        //             }])->pluck('scholar_count')->first();

        //         $prov = [];
        //         foreach($provinces as $province){
        //             $data1 = LocationProvince::where('code',$province)
        //             ->withCount([
        //                 'scholars', 
        //                 'scholars as scholars_count' => function ($query) use ($year,$program){
        //                     $query->whereHas('scholar',function ($query) use ($year,$program) {
        //                         $query->where('awarded_year', $year)->where('program_id',$program->id);
        //                     });
        //             }])->first();
        //             $prov[] = [
        //                 'name' => $data1->name,
        //                 'count'=> $data1->scholars_count
        //             ];
        //         }

        //         $prog[] = [
        //             'name' => $program->name,
        //             'total' => array_sum(array_column($prov, 'count')),
        //             'provinces' => $prov
        //         ];
        //     }
        //     $arr[] = [
        //         'year' => $year,
        //         'total' => array_sum(array_column($prog, 'total')),
        //         'programs' => $prog
        //     ];
        // }
    }
    public function schools(){
        $data = SchoolCampus::with('school')->withCount('scholars')->orderBy('scholars_count', 'desc')->take(5)->get();
        return $data;
    }

    public function courses(){
        $data = ListCourse::withCount('scholars')->orderBy('scholars_count', 'desc')->take(5)->get();
        return $data;
    }
}
