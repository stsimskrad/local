<?php

namespace App\Http\Controllers\Evaluation;

use Hashids\Hashids;  
use App\Models\Prospectus;
use App\Models\SchoolCourse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ProspectusController extends Controller
{
    public function index($school,$course,$count,$keyword){
        $data = Prospectus::with('course','added')->paginate($count);
        return DefaultResource::collection($data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'school_year' => 'sometimes|required'
        ]);

        $data = \DB::transaction(function () use ($request){
            if($request->editable == "true"){
                $data = Prospectus::where('id',$request->id)->first();
                $data->update($request->except('editable'));
                return $data;
            }else{
                $level = ['First Year','Second Year','Third Year','Fourth Year','Fifth Year'];
                $semesters = ['First Semester', 'Second Semester', 'Summer Class'];
                $years = $request->years;
                $group = []; $courses = [];

                for ($i = 0; $i < $years; ++$i) {
                    $sem = [];
                    foreach($semesters as $key=>$semester){
                        // if($key == 0 && $i == 0){
                        //     $courses[] = [
                        //         'code' => 'BEM111',
                        //         'name' => 'Engineering Calculus 1',
                        //         'unit' => 3
                        //     ];
                        // }else{
                        //     $courses = [];
                        // }

                        $sem[] = [
                            'semester' => $semester,
                            'total' => 0,
                            'courses' => $courses
                        ];
                    }

                    $group[] = [
                        'year_level' => $level[$i],
                        'semesters' => $sem
                    ];
                }

                $subjects = json_encode($group,true);
                $data = Prospectus::create(array_merge($request->all(), ['subjects' => $subjects, 'added_by' => \Auth::user()->id]));
                $data = Prospectus::where('id',$data->id)->first();
                return $data;
            }
        });
        return new DefaultResource($data);
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = SchoolCourse::with('school.school','course','prospectus')->where('id',$id[0])->first();
        return new DefaultResource($data);
    }

    public function select($id){
        $data = Prospectus::where('id',$id)->where('is_active',0)->orderBy('created_at','DESC')->first();
        return new DefaultResource($data);
    }

    public function test(){
        $data = Prospectus::whereJsonContains('subjects', 
            [
                [
                    'semesters' => [
                        'semester' => 'First Semester'
                    ]
                ]
            ]
        )->get();
        return $data;
    }
}
