<?php

namespace App\Http\Controllers\Qualifier;

use App\Models\Qualifier;
use App\Models\ListAgency;
use App\Models\SchoolCampus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EndorsementController extends Controller
{
    public function index(){
        $region_code = $this->agency();
        try{
            $url = 'http://stsims.main/api/endorsements/'.$region_code;
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $datas = response()->json(json_decode($response));
            // $datas = json_decode($response);
           
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function store(Request $request){

        try{
            $url = 'http://stsims.main/api/endorsement/store';
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                    'code' => '01101011 01110010 01100001 01100100',
                    'school_id' => $request->school_id,
                    'course_id' => $request->course_id,
                    'name' => $request->name,
                    'spas_id' => $request->spas_id,
                    'information' => json_encode($request->information),
                    'endorsed_to' => $this->school($request->school_id),
                    'endorsed_by' => $this->agency()
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response);

            if($data->code == 200){
                $qualifier = Qualifier::where('id',$request->id)->update(['is_referral' => 1]);
            }

            return response()->json([
                'message' => $data->message,
                'data' => $data->data
            ], $data->code);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function agency(){
        $agency_id = config('app.agency');
        $agency = ListAgency::where('id',$agency_id)->first();
        return $region_code = $agency->region_code;
    }

    public function school($id){
        $data = SchoolCampus::with('municipality.province.region')->where('id',$id)->first();
        return $data->municipality->province->region->code;
    }
}
