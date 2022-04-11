<?php

namespace App\Http\Controllers\Benefit;

use App\Models\Scholar;
use App\Models\ScholarFinancial;
use App\Models\ScholarFinancialGroup;
use App\Models\ScholarFinancialList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\DropdownTrait;
use App\Http\Traits\FinancialTrait;
use App\Http\Traits\FinancialCreateTrait;
use App\Http\Resources\DefaultResource;
use App\Http\Requests\FinancialRequest;
use Hashids\Hashids;        

class IndexController extends Controller
{
    use FinancialTrait, FinancialCreateTrait, DropdownTrait;

    public function lists($keyword,$year,$count){
        $data = ScholarFinancialGroup::with('financials','financials.scholar:id,profile_id','financials.scholar.profile:id,firstname,lastname,middlename,suffix')
        ->with('user:id','user.profile:user_id,firstname,lastname')
        ->where(function ($query) use ($keyword,$year) {
            $query->where('code', 'LIKE', '%'.$keyword.'%');
            ($year != '-') ? $query->whereYear('created_at', $year) : '';
        })->orderBy('created_at','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }

    public function index($id,$count){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = ScholarFinancial::with('group')->with('lists','lists.benefit')->where('scholar_id',$id)->orderBy('created_at','DESC')->paginate($count);
        return DefaultResource::collection($data);
    }   

    public function store(FinancialRequest $request){
        $result = \DB::transaction(function () use ($request){
            $users = [];
            $sf = ScholarFinancialGroup::whereYear('created_at',date('Y'))->count()+1;
            $sf = 'FNCLBNFT-'.date('Y').'-'.str_pad(($sf), 4, '0', STR_PAD_LEFT);

            $group = new ScholarFinancialGroup;
            $group->code = $sf;
            $group->added_by = \Auth::user()->id;
            $group->release_type = $request->release;
            $group->academic_year = $request->ay;
            $group->session_type = $request->session;
            if($group->save()){
                if($request->type == "Individual"){
                    $hashids = new Hashids('krad',10);
                    $id = $hashids->decode($request->user);
                    array_push($users,$id[0]);
                }else{
                    $users = $request->user;
                }
                $result = $this->create($group->id,$request,$users);
               
                $group->total =  $result['total'];
                $group->save();

                return $result;
            }
        });
        return $result;
    }

    public function stipend($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = ScholarFinancialList::where('benefit_id',44)
        ->whereHas('financial',function ($query) use ($id){
            $query->where('scholar_id',$id);
            $query->whereHas('group',function ($query) use ($id){
                $query->where('academic_year','2021-2022');
            });
        })->get()->toArray();

        $stipends = [];
        for($i = 1; $i <= 12; $i++){
            $m = date('F', mktime(0, 0, 0, $i, 10));
            $key=array_search($i,array_column($data, 'flag'));
            if($key !== false){
                $stipends[] = [
                    'month' => $m,
                    'amount' => $data[$key]['amount'],
                    'date' => $data[$key]['created_at'],
                ];
            }else{
                $stipends[] = [
                    'month' => $m,
                    'amount' => '<i class="text-danger bx bx-x"></i>',
                    'date' => '<i class="text-danger bx bx-x"></i>',
                ];
            }
        } 
        return $stipends;
    }

    public function breakdown($id,$year,$award,$course){
        $benefits = $this->dropdown("Benefit Type","-");
        $response = []; $years = [];  $lists = []; $term = 'Semester';
        $terms = ['1st term','2nd term','3rd term'];

        for($x=0; $x<$course; $x++){
            $years[] = $award.'-'.($award+1);
            $award++;
        }

        foreach($benefits as $key=>$benefit){
            $lists = [];          
            $lists[] = [
                'selectable' => ($benefit->type != "One-time") ? 'unselectable' : '',
                'data' =>($benefit->type != "One-time") ? '' : $this->check($id,$benefit->id,null,null)
            ];
            
            foreach($terms as $term){
                $lists[] = [
                    'selectable' => ($benefit->type != "Term") ? 'unselectable' : '',
                    'data' =>($benefit->type != "Term") ? '' : $this->check($id,$benefit->id,$term,$year)
                ];
            }
            
            foreach($years as $yr){
                $lists[] = [
                    'selectable' => ($benefit->type != "Academic Year") ? 'unselectable' : '',
                    'data' =>($benefit->type != "Academic Year") ? '' : $this->check($id,$benefit->id,null,$yr)
                ];
            }
            
            if($key != 0){
                $response[] = ['name' => $benefit->name, 'type' => $benefit->type, 'lists' => $lists];
            }
        }
        return $response;
    }

    public function types($id,$type){
        $data = ScholarFinancialList::with()->where('type',$type)
        ->whereHas('financial',function ($query){
            $query->where('scholar_id',3);
        })->get();
        return $data;
    }

    public function profile($array){
        $info = (!empty(json_decode($array))) ? json_decode($array) : NULL;
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($info->code);
        $total = ScholarFinancial::where('scholar_id',$id)->sum('total');

        $profile = [
            'total' => $total,
            'breakdown' => $this->breakdown($id,$info->year,$info->award,$info->course)
        ];

        return $profile;
    }
}
