<?php

namespace App\Http\Controllers\Scholarship;

use App\Models\Scholar;
use App\Models\ListAgency;
use App\Models\ListProgram;
use App\Models\ListDropdown;
use App\Models\FinancialGroup;
use App\Models\Qualifier;
use App\Exports\ScholarExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Report\ScholarResource;

class ReportController extends Controller
{
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

    public function category(){
        $total = Scholar::count();
        $datas = ListProgram::orderBy('id','ASC')->get();
        $array = [];
        foreach($datas as $data){
            $count = Scholar::where('program_id',$data->id)->count();
            $graduate = Scholar::where('program_id',$data->id)->where('status_id',36)->count();
            $good = Scholar::where('program_id',$data->id)->where('status_id',31)->count();
            $warning = Scholar::where('program_id',$data->id)->whereNotIn('status_id',[31,36])->count();

            $array[] = [
                'id' => $data->id,
                'name' => $data->name,
                'count' => $count,
                'graduate' => $graduate,
                'good' => $good,
                'warning' => $warning,
                'total' => $total
            ];
        }
        return $array;
    }

    public function status(){
        $total = Scholar::count();
        $datas = ListDropdown::where('classification','Status')->orderBy('id','ASC')->get();
        $array = [];
        foreach($datas as $data){
            $count = Scholar::where('status_id',$data->id)->count();
            $array[] = [
                'id' => $data->id,
                'name' => $data->name,
                'count' => $count,
                'type' => $data->type,
                'total' => $total
            ];
        }
        return $array;
    }

    public function dashboard(){
        $c = Scholar::count();
        $o = Scholar::where('status_id',30)->count();
        $g = Scholar::where('status_id',35)->count();

        $array = [
            ['counts' => $c,'name' => 'Total Scholars'],
            ['counts' => $o,'name' => 'Ongoing Scholars'],
            ['counts' => $g, 'name' => 'Total Graduates'],
        ];

        return $array;
    }

    public function cats(){
        $total = Scholar::count();
        $datas = ListProgram::orderBy('id','ASC')->get();
        $series = []; $labels = []; $array = [];
        foreach($datas as $data){
            $count = Scholar::where('category_id',$data->id)->count();

            array_push($series,$count);
            array_push($labels,$data->name);
        }
        return $array = [
            'series' => $series,
            'labels' => $labels
        ];
    }

    public function scholars($info){
        ini_set('memory_limit', '-1');
        $info = (!empty(json_decode($info))) ? json_decode($info) : NULL;

        $agency_id = config('app.agency');
        $agency = ListAgency::with('region')->where('id',$agency_id)->first();

        $group = FinancialGroup::with('semester')->orderBy('created_at','DESC')->first();

        $data = Scholar::where('is_completed',1)->
        where(function($query) use ($info) {  
            ($info->program == '') ? '' : $query->where('program_id',$info->program);
            ($info->status == '') ? '' : $query->where('status_id',$info->status);
            ($info->from != '' && $info->to != '') ? $query->whereBetween('awarded_year',[$info->from,$info->to]) : '';
        })
        ->with('profile.user','status','program')
        ->with('profile.address.municipality.province.region')
        ->with('education.school.school','education.course','education.award')
        ->orderBy('awarded_year','DESC')->get();

        $scholars = ScholarResource::collection($data);
        
        $array = [
            'scholars' => $scholars,
            'agency' => $agency,
            'group' => $group
        ];

        if($info->type == 'scholars'){
            $pdf = \PDF::loadView('layouts.prints.scholars',$array)->setPaper('a4', 'landscape');
            return $pdf->download('List of Scholars.pdf');
        }else if($info->type == 'graduates'){
            $pdf = \PDF::loadView('layouts.prints.graduates',$array)->setPaper('a4', 'landscape');
            return $pdf->download('List of Graduate Scholars.pdf');
        }else{
            $programs = ListProgram::where('is_sub',0)->get();
            $awards = ListDropdown::where('classification','Award')->get();
            $array['awards'] = $awards; $total_no = 0; $total_awardee = 0; 
            $totals = [];
            foreach($programs as $index=>$program){
                $data = Scholar::where('is_completed',1)->where('program_id',$program->id)->count();
                $list = [];

                foreach($awards as $index2=>$award){
                    $count = Scholar::where('is_completed',1)->where('program_id',$program->id)
                    ->whereHas('education',function ($query) use ($award) {
                        $query->where('award_id',$award->id);
                    })->count();
                    array_push($list,$count);
                }

                $array2[] = [
                    'name' => $program->name,
                    'count' => $data,
                    'list' => $list,
                    'total' => array_sum($list)
                ];
                $total_no += $data;
                $total_awardee += array_sum($list);
            }

            foreach($awards as $index2=>$award){ 
                $tot = 0;
                foreach($programs as $index=>$program){
                    $tot += $array2[$index]['list'][$index2];
                }
                array_push($totals,$tot);
            }

            $array2[] = [
                'name' => 'Total',
                'count' => $total_no,
                'list' => $totals,
                'total' => $total_awardee
            ];
            $array['scholars'] = $array2;

            $pdf = \PDF::loadView('layouts.prints.awardees',$array)->setPaper('a4', 'landscape');
            return $pdf->download('List of Graduate Scholars with Awards.pdf');
        }
        // return Excel::download(new ScholarExport, 'scholars.xlsx');
    }
}
