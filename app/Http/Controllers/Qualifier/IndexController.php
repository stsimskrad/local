<?php

namespace App\Http\Controllers\Qualifier;

use App\Models\Qualifier;
use App\Models\ProfileAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\QualifierResource;
use App\Http\Resources\Qualifier\IndexResource;

class IndexController extends Controller
{
    public function index(Request $request){
        $data = Qualifier::with('profile.address.region','profile.address.province','profile.address.municipality','profile.address.barangay')->with('program')
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
        return IndexResource::collection($data);
    }

    public function store(Request $request){
        $data = ProfileAddress::where('id',$request->id)->first();
        $data->update(array_merge($request->except('editable','qualifier_id')));
        $q = Qualifier::where('id',$request->qualifier_id)->first();
        return new IndexResource($q);
    }
}
