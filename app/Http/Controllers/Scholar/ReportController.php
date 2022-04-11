<?php

namespace App\Http\Controllers\Scholar;

use App\Models\Scholar;
use App\Models\Dropdown;
use App\Models\Qualifier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function totals(){
        $total = Scholar::count();
        $graduates = Scholar::where('status_id',35)->count();
        $ongoing = Scholar::whereIn('status_id',[30,31,32,33,34])->count();

        $array = [
            ['counts' => $total, 'name' => 'Total Scholars', 'icon' => 'bx-group', 'color' => 'success'],
            ['counts' => $graduates,'name' => 'Total Graduates', 'icon' => 'bxs-graduation', 'color' => 'info'],
            ['counts' => $ongoing,'name' => 'Ongoing Scholars', 'icon' => 'bx-user-circle', 'color' => 'primary']
        ];

        return $array;
    }

    public function category(){
        $total = Scholar::count();
        $datas = Dropdown::where('classification','Category')->orderBy('id','ASC')->get();
        $array = [];
        foreach($datas as $data){
            $count = Scholar::where('category_id',$data->id)->count();
            $graduate = Scholar::where('category_id',$data->id)->where('status_id',35)->count();
            $good = Scholar::where('category_id',$data->id)->where('status_id',30)->count();
            $warning = Scholar::where('category_id',$data->id)->whereNotIn('status_id',[30,35])->count();

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
        $datas = Dropdown::where('classification','Status')->orderBy('id','ASC')->get();
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
        $datas = Dropdown::where('classification','Category')->orderBy('id','ASC')->get();
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
}
