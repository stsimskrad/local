<?php

namespace App\Http\Controllers\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScholarTracer;
use App\Http\Requests\TracerRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Scholarship\TracerResource;
use Hashids\Hashids;

class TraceController extends Controller
{
    public function index($type,$id,$count){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = ScholarTracer::where('type',$type)->where('scholar_id',$id)->orderBy('created_at','DESC')->paginate($count);
        return TracerResource::collection($data);
    }

    public function store(TracerRequest $request){

        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->user);

        switch($request->type){
            case 'Employment':
                $json = $this->employment($request);
            break;
            case 'History':
                $json = $this->history($request);
            break;
            case 'Affliation':
                $json = $this->afflication($request);
            break;
            case 'Award':
                $json = $this->awards($request);
            break;
            case 'Research':
                $json = $this->research($request);
            break;
        };
        
        $data = new ScholarTracer;
        $data->type = $request->type;
        $data->information = json_encode($json);
        $data->scholar_id = $id[0];
        $data->checked_by = \Auth::user()->id;
        $data->save();

        return new TracerResource($data);
    }

    public function employment(){
        $employed = [
            'status' => $status,
            'company' => $company,
            'address' => $address,
            'sector' => $sector
        ];

        $selfemployed = [
            'status' => $status,
            'business_name' => $business,
            'business_address' => $address,
            'company_name' => $company,
            'operation_year' => $year
        ];

        $unemployed = [
            'status' => $status,
            'reason' => $reason
        ];
    }

    public function history(Request $request){
        $history = [
            'position' => $request->position,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'is_related' => $request->job,
            'company' => $request->company,
            'address' => $request->address
        ];

        return $history;
    }

    public function awards(Request $request){
        $awards = [
            'award' => $request->award,
            'body' => $request->body,
            'given' => $request->given
        ];

        return $awards;
    }

    public function research(Request $request){
        $research = [
            'research' => $request->research,
            'duration' => $request->duration,
            'fund_source' => $request->fund,
            'nature_involvement' => $request->involvement,
            'location' => $request->location
        ];

        return $research;
    }

    public function afflication(Request $request){
        $affliation = [
            'organization' => $request->organization,
            'duration' => $request->duration,
            'position' => $request->position,
            'address' => $request->address
        ];

        return $affliation;
    }
}
