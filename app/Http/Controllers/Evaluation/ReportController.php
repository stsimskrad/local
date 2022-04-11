<?php

namespace App\Http\Controllers\Evaluation;

use App\Models\Scholar;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Evaluation\FailedResource;

class ReportController extends Controller
{
    public function reports(){

        $not_clear = Scholar::whereHas('enrollments',function ($query) {
            $query->where('is_clear',0);
        })->pluck('id');

        $with_failing = Scholar::whereHas('enrollments',function ($query) {
            $query->whereHas('lists',function ($query) {
                $query->where('is_failed',1);
            });
        })->pluck('id');

        $subjects = ScholarEnrollmentList::where('is_failed',1)->groupBy('subject','code')
        ->select('subject','code', \DB::raw('count(*) as total'))
        ->orderBy('total','DESC')
        ->paginate(5);

        $array = [
            [
                'name' => 'Incomplete Grades',
                'count' => count($not_clear),
                'data' => $not_clear
            ],
            [
                'name' => 'With Failures',
                'count' => count($with_failing),
                'data' => $with_failing
            ],
            [
                'data' => $subjects
            ]
        ];

        return $array;
    }
}
