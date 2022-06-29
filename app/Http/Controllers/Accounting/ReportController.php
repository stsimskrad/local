<?php

namespace App\Http\Controllers\Accounting;

use App\Models\Allotment;
use App\Models\Disbursement;
use App\Models\ListExpense;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $year = 2020;
        $quater = 1;
        
        $expenses = ListExpense::
        with(["allotments" => function($query) use ($year){
            $query->whereHas('allotment',function ($query) use ($year){
                $query->whereMonth('credited_at', '>=', '01')->whereMonth('credited_at', '<=', '03')->whereYear('credited_at',$year);
            });
        }])->withCount(['allotments AS allotment_sum' => function ($query) use ($year) {
            $query->whereHas('allotment',function ($query) use ($year){
                $query->whereMonth('credited_at', '>=', '01')->whereMonth('credited_at', '<=', '03')->whereYear('credited_at',$year);
            })->select(\DB::raw("SUM(amount) as sum"));
        }])->with(["disbursements" => function($query) use ($year){
            $query->whereMonth('created_at', '>=', '01')->whereMonth('created_at', '<=', '03')->whereYear('created_at',$year);
        }])->withCount(['disbursements AS disbursement_sum' => function ($query) use ($year){
                $query->select(\DB::raw("SUM(amount) as sum"));
                $query->whereMonth('created_at', '>=', '01')->whereMonth('created_at', '<=', '03')->whereYear('created_at',$year);
            }
        ])
        ->with(["balances" => function($query) use ($year){
            $query->whereMonth('created_at', '>=', '10')->whereMonth('created_at', '<=', '12')->whereYear('created_at',$year-1);
        }])->withCount(['balances AS balance_sum' => function ($query) use ($year){
                $query->select(\DB::raw("SUM(amount) as sum"));
                $query->whereMonth('created_at', '>=', '10')->whereMonth('created_at', '<=', '12');
                $query->whereYear('created_at',$year-1);
            }
        ])
   ->get();

        $query = Allotment::query();
        switch($quater){
            case 1:
                $query->whereMonth('credited_at', '>=', '01')->whereMonth('credited_at', '<=', '03');
            break;
            case 2:
                $query->whereMonth('credited_at', '>=', '04')->whereMonth('credited_at', '<=', '06');
            break;
            case 3:
                $query->whereMonth('credited_at', '>=', '07')->whereMonth('credited_at', '<=', '09');
            break;
            case 4:
                $query->whereMonth('credited_at', '>=', '10')->whereMonth('credited_at', '<=', '12');
            break;
        }
        $query->withCount([
        'lists AS lists_sum' => function ($query) {
                $query->select(\DB::raw("SUM(amount) as sum"));
            }
        ]);
        $allotments = $query->whereYear('credited_at',$year)->get();
        
        $array = [
            'allotments' => $allotments,
            'expenses' => $expenses
        ];

        return $array;
    }
}
