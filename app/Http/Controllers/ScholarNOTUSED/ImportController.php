<?php

namespace App\Http\Controllers\Scholar;

use App\Models\Scholar;
use App\Models\Profile;
use App\Models\ListDropdown;
use App\Models\ScholarEducation;
use App\Imports\ScholarImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\CheckTrait;

class ImportController extends Controller
{
    use CheckTrait;

    public function store(Request $request){
        set_time_limit(0);
        $result = \DB::transaction(function () use ($request){
            $scholars = $request->users;
            $users = array();
            $success = array();
            $failed = array();
            $duplicate = array();

            foreach($scholars as $scholar){
                $count = Scholar::where('old_id',$scholar['id'])->count();
                if($count == 0){

                    $parents = [
                        'mother' => 'n/a',
                        'father' => 'n/a',
                    ];
    
                    $information = [
                        'birth_place' => 'n/a',
                        'course' => $scholar['course'],
                        'school' => $scholar['school'],
                        'address' => $scholar['address'],
                        'level' => $scholar['level'],
                        'parents' => $parents
                    ];

                    $user = [ 
                        'is_completed' => 0,
                        'firstname' => $scholar['firstname'],
                        'middlename' => $scholar['middlename'],
                        'lastname' => $scholar['lastname'],
                        'suffix' => $scholar['suffix'],
                        'information' => json_encode($information),
                        'created_at'	=> now(),
                        'updated_at'	=> now()
                    ];

                    \DB::beginTransaction();
                    $profile = Profile::create($user);

                    $course = $this->checkCourse($scholar['course']);
                    $school = $this->checkSchool($scholar['school']);

                    if($profile){            
                        $haha = [
                            'is_completed' => 0,
                            'is_undergrad' => $this->checkCategory($scholar['category']),
                            'category_id' => $this->category($scholar['category']),
                            'status_id' =>  $scholar['status']['id'],
                            'profile_id' => $profile->id,
                            'old_id' =>  $scholar['id'],
                            'awarded_year' =>  $scholar['awarded_year'],
                            'created_at'	=> now(),
                            'updated_at'	=> now()
                        ];
                        
                        $q = Scholar::create($haha); 
                        if($q){
                            $school = [
                                'scholar_id' => $q->id,
                                'course_id'=> $course,
                                'school_id'=> $school,
                                'level_id' => $this->level($scholar['level']),
                                'created_at'	=> now(),
                                'updated_at'	=> now()
                            ];
                            $s = ScholarEducation::insertOrIgnore($school);
                            $address = $this->checkAddress($scholar['address'],$q->id);
                            array_push($success,$scholar['id']);
                            \DB::commit();
                        }else{
                            array_push($failed,$scholar['id']);
                            \DB::rollback();
                        }

                    }else{
                        array_push($failed,$scholar['id']);
                        \DB::rollback();
                    }
                }else{
                    array_push($duplicate,$scholar['id']);
                }
            }

            $result = [
                'success' => $success,
                'failed' => $failed,
                'duplicate' => $duplicate,
            ];
            return $result;
        });
        return $result;
    }

    public function index(Request $request){
        $data =  Excel::toCollection(new ScholarImport,$request->import_file);
        $suffixes = array('jr','jr.','sr.','sr','III','II','iii','ii');
        $rows = $data[0]; 
        $year = '';

        foreach($rows as $row){ 
            if($row[1] == ''){
                $year = $row[0];
            }else{
                $test = explode(",",$row[1]);
               
                $lastname = $test[0];
                $wew = preg_replace('/\s+/', ' ', $test[1]);
                $name = preg_split('/\s+/', ltrim($wew));

                switch(count($name)){
                    case '2':
                        $firstname = $name[0];
                        $middlename = $name[1];
                        $suffix = '';
                    break;
                    case '3':
                        if(in_array($name[2],$suffixes)){ 
                            $firstname = $name[0];
                            $middlename = $name[1];
                            $suffix = $$name[2];
                        }else{
                            $firstname = $name[0].' '.$name[1];
                            $middlename = $name[2]; 
                            $suffix = '';
                        } 
                    break;
                    case '4':
                        if(in_array($name[3],$suffixes)){ 
                            $firstname = $name[0].' '.$name[1];
                            $middlename = $name[2];
                            $suffix = $$name[3];
                        }else{
                            $firstname = $name[0].' '.$name[1];
                            $middlename = $name[2].' '.$name[3];
                            $suffix = '';
                        } 
                    break;
                }

                $status = ListDropdown::where('classification','Status')->where('name',$row[5])->first();

                $information[] = [
                    'id' => $row[0],
                    'firstname' => strtoupper($firstname),
                    'middlename' => strtoupper($middlename),
                    'lastname' => strtoupper($lastname),
                    'suffix' => strtoupper($suffix),
                    'school' => $row[2],
                    'course' => $row[3],
                    'level' => $row[4],
                    'status' => $status,
                    'address' => $row[6],
                    'category' => $row[7],
                    'awarded_year' => $year
                ];
            }
        }
        return $information;
    }
}
