<?php

namespace App\Http\Controllers\Qualifier;

use App\Models\Qualifier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\QualifierResource;

class IndexController extends Controller
{
    public function index(Request $request){
        $data = Qualifier::with('profile')
        ->whereHas('profile',function ($query) use ($request) {
            $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$request->keyword.'%')
            ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$request->keyword.'%')
            ->orWhere('spas_id','LIKE','%'.$request->keyword.'%');
        })
        ->where(function ($query) use ($request) {
            switch($request->type){
                case 'Qualifiers' : 
                    $query->where('is_qualified',NULL)->where('is_referral',0);  
                break;
                case 'Endorsed' : 
                    $query->where('is_referral',1); 
                break;
                case 'Qualified' : 
                    $query->where('is_qualified',1);   
                break;
            }
            ($request->is_undergrad == 'all') ? '' : $query->where('is_undergrad',$request->is_undergrad);
            ($request->program == null) ? '' : $query->where('program_id',$request->program);
            ($request->year == null) ? '' : $query->where('year',$request->year);
        })
        ->orderBy('id','DESC')->paginate($request->count);
        return QualifierResource::collection($data);
    }
}
