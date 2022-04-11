<?php

namespace App\Http\Controllers\Sync;

use App\Models\Agency;
use App\Models\Course;
use App\Models\Dropdown;
use App\Models\Expense;
use App\Models\School;
use App\Models\SchoolCampus;
use App\Models\LocationRegion;
use App\Models\LocationBarangay;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function addresses($type,$category){
        if($category == 'all'){
            $arrays = ['regions','provinces','municipalities','barangays'];
        }else{
            $arrays = [];
            array_push($arrays,strtolower($category));
        }
        set_time_limit(0);

        foreach($arrays as $array){
            try{
                $url = 'http://stsims.main/api/01101011%2001110010%2001100001%2001100100/locations/'.$array;
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
            //    $datas = response()->json(json_decode($response));
                $datas = json_decode($response);
                $addresses = [];
                foreach($datas as $data){
                    switch($array){
                        case 'regions':
                            ($type == 'check') ? $regions[] = (array)$data : $q = LocationRegion::insertOrIgnore((array)$data); 
                        break;
                        case 'provinces':
                            ($type == 'check') ? $provinces[] = (array)$data : $q = LocationProvince::insertOrIgnore((array)$data); 
                        break;
                        case 'municipalities':
                            ($type == 'check') ? $municipalities[] = (array)$data : $q = LocationMunicipality::insertOrIgnore((array)$data); 
                        break;
                        case 'barangays':
                            ($type == 'check') ? $barangays[] = (array)$data : $q = LocationBarangay::insertOrIgnore((array)$data); 
                        break;
                    }
                    
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }

        if($type == 'check'){
            $addresses = [
                'Regions' => [
                    'downloaded' => LocationRegion::count(),
                    'count' => count($regions)
                ],
                'Provinces' => [
                    'downloaded' => LocationProvince::count(),
                    'count' => count($provinces)
                ],
                'Municipalities' => [
                    'downloaded' => LocationMunicipality::count(),
                    'count' => count($municipalities)
                ],
                'Barangays' => [
                    'downloaded' => LocationBarangay::count(),
                    'count' => count($barangays)
                ]
            ];
            return $addresses;
        }
        if($category == 'all') {
            return true;
        }else{
            switch($array){
                case 'regions':
                    return LocationRegion::count();
                break;
                case 'provinces':
                    return LocationProvince::count();
                break;
                case 'municipalities':
                    return LocationMunicipality::count();
                break;
                case 'barangays':
                    return LocationBarangay::count();
                break;
            }
        }
        
    }

    public function lists($type,$category){
        if($category == 'all'){
            $arrays = ['agencies','dropdowns','courses','expenses'];
        }else{
            $arrays = [];
            array_push($arrays,strtolower($category));
        }
        set_time_limit(0);

        foreach($arrays as $array){
            try{
                $url = 'http://stsims.main/api/01101011%2001110010%2001100001%2001100100/'.$array;
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
                //$datas = response()->json(json_decode($response));
                $datas = json_decode($response);
                foreach($datas as $data){
                    switch($array){
                        case 'agencies':
                            ($type == 'check') ? $agencies[] = (array)$data : $q = Agency::insertOrIgnore((array)$data); 
                        break;
                        case 'dropdowns':
                            ($type == 'check') ? $dropdowns[] = (array)$data : $q = Dropdown::insertOrIgnore((array)$data); 
                        break;
                        case 'courses':
                            ($type == 'check') ? $courses[] = (array)$data : $q = Course::insertOrIgnore((array)$data); 
                        break;
                        case 'expenses':
                            ($type == 'check') ? $expenses[] = (array)$data : $q = Expense::insertOrIgnore((array)$data); 
                        break;
                        case 'schools':
                            $arr = (array)$data;
                            $campuses = array_splice($arr,10);
                            $q = School::insertOrIgnore($arr);
                            foreach($data->campuses as $campus)
                            {   
                                $q = SchoolCampus::insertOrIgnore((array)$campus);
                            } 
                        break;
                    }
                    
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        if($type == 'check'){
            $addresses = [
                'Dropdowns' => [
                    'data' => Dropdown::all(),
                    'downloaded' => Dropdown::count(),
                    'count' => count($dropdowns)
                ],
                'Agencies' => [
                    'data' => Agency::all(),
                    'downloaded' => Agency::count(),
                    'count' => count($agencies)
                ],
                'Courses' => [
                    'data' => Course::all(),
                    'downloaded' => Course::count(),
                    'count' => count($courses)
                ],
                'Expenses' => [
                    'data' => Expense::all(),
                    'downloaded' => Expense::count(),
                    'count' => count($expenses)
                ],
            ];
            return $addresses;
        }

        if($category == 'all') {
            return true;
        }else{
            switch($array){
                case 'agencies':
                    return Agency::count();
                break;
                case 'dropdowns':
                    return Dropdown::count();
                break;
                case 'courses':
                    return Course::count();
                break;
                case 'expenses':
                    return Expense::count();
                break;
            }
        }
    }

    public function schools($type,$category,$agency_id = null){
        if($category == 'local' || $category == 'all'){
            $agency_id = config('app.agency');
            $agency = Agency::where('id',$agency_id)->first();
            $region_code = $agency->region_code;
        }else{ //custom region
            $agency_id = $agency_id;
            $agency = Agency::where('id',$agency_id)->first();
            $region_code = $agency->region_code;
        }

        try{
            $url = 'http://stsims.main/api/01101011%2001110010%2001100001%2001100100/schools/'.$category.'/'.$region_code;
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
            $datas = json_decode($response);
            if($type == 'check'){
                $s[] = (array)$datas->data;
            }else{
                $lists= $datas->data;
                foreach($lists as $data){
                    $arr = (array)$data;
                    $campuses = array_splice($arr,9);
                    $q = School::insertOrIgnore($arr);
                    foreach($data->campuses as $campus)
                    {   
                        $q = SchoolCampus::insertOrIgnore((array)$campus);
                    } 
                }
            } 

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        if($type == 'check'){
            $agency_id = config('app.agency');
            $agency = Agency::where('id',$agency_id)->first();
            $region = $agency->region_code;

            $schools = [
                'overall' => [
                    'all' => $datas->schools,
                    'campuses' => $datas->campuses,
                    'downloaded_schools' => School::count(),
                    'downloaded_campuses' => SchoolCampus::count(),
                ],
                'regional' => [
                    'all' => $datas->region_schools,
                    'campuses' => $datas->region_campuses,
                    'downloaded_schools' => School::whereHas('campuses',function ($query) use ($region) {
                        $query->whereHas('municipality',function ($query) use ($region) {
                            $query->whereHas('province',function ($query) use ($region) {
                                $query->whereHas('region',function ($query) use ($region) {
                                    $query->where('region_code',$region);
                                });
                            });
                        });
                    })->count(),
                    'downloaded_campuses' => SchoolCampus::whereHas('municipality',function ($query) use ($region) {
                        $query->whereHas('province',function ($query) use ($region) {
                            $query->whereHas('region',function ($query) use ($region) {
                                $query->where('region_code',$region);
                            });
                        });
                    })->count(),
                    'other_schools' => School::whereHas('campuses',function ($query) use ($region) {
                        $query->whereHas('municipality',function ($query) use ($region) {
                            $query->whereHas('province',function ($query) use ($region) {
                                $query->whereHas('region',function ($query) use ($region) {
                                    $query->where('region_code','!=',$region);
                                });
                            });
                        });
                    })->count(),
                    'other_campuses' => SchoolCampus::whereHas('municipality',function ($query) use ($region) {
                        $query->whereHas('province',function ($query) use ($region) {
                            $query->whereHas('region',function ($query) use ($region) {
                                $query->where('region_code','!=',$region);
                            });
                        });
                    })->count(),
                ]
            ];
            return $schools;
        }
    }

    public function allSchools(){
        $url = 'http://stsims.main/api/01101011%2001110010%2001100001%2001100100/schools/all';
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
        $datas = json_decode($response);
        return $datas;
    }
}
