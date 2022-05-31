<?php

namespace App\Http\Controllers\Insight;

use App\Models\School;
use App\Models\Profile;
use App\Models\Scholar;
use App\Models\Qualifier;
use App\Models\ListCourse;
use App\Models\ListAgency;
use App\Models\ListProgram;
use App\Models\ListDropdown;
use App\Models\SchoolCampus;
use App\Models\ProfileAddress;
use App\Models\LocationProvince;
use App\Models\ScholarEducation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        $agency_id = config('app.agency');
        $agency = ListAgency::with('region')->where('id',$agency_id)->first();
        $region_code = $agency->region_code;

        $array = [
            'lists' => $this->lists(),
            'counts' => $this->counts($region_code)
        ];

        return $array;
    }

    public function lists(){
        return [
            'graphs' => $this->graphs(),
            'schools' => $this->schools(),
            'courses' => $this->courses(),
            'statuses' => $this->statuses(),
        ];
    }

    public function graphs(){
        return [
            $this->scholars(),
            $this->qualifiers(),
            $this->graduates()
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

    public function statuses(){
        $data = ListDropdown::where('classification','Status')->withCount('status')->orderBy('status_count', 'desc')->get();
        return $data;
    }

    public function schools(){
        $data = SchoolCampus::with('school')->withCount('scholars')->orderBy('scholars_count', 'desc')->take(5)->get();
        return $data;
    }

    public function courses(){
        $data = ListCourse::withCount('scholars')->orderBy('scholars_count', 'desc')->take(5)->get();
        return $data;
    }

    public function counts($region_code){
        return [
            'type' => Scholar::select(\DB::raw('count(*) as total'))->whereIn('is_undergrad',[0,1])->groupBy('is_undergrad')->get(),
            'gender' => Profile::select(\DB::raw('count(*) as total'))->whereIn('gender',[1,2])->groupBy('gender')->get(),
            'school' => School::select(\DB::raw('count(*) as total'))->whereIn('class_id',[7,8])
            ->whereHas('campuses',function ($query) use ($region_code){
                $query->whereHas('municipality',function ($query) use ($region_code){
                    $query->whereHas('province',function ($query) use ($region_code){
                        $query->whereHas('region',function ($query) use ($region_code){
                            $query->where('code',$region_code);
                        });
                    });
                });
            })->groupBy('class_id')->get(),
            'total' => Scholar::count()
        ];
    }

    public function years(Request $request){
        $provinces = ProfileAddress::groupBy('province_code')->pluck('province_code');
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
                    ->whereHas('profile',function ($query) use ($province,$pro) {
                        $query->whereHas('address',function ($query) use ($province,$pro) {
                            ($province != null) ? $query->where('province_code', $province) : '';
                        });
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
    }

}

