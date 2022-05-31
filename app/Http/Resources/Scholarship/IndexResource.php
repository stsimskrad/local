<?php

namespace App\Http\Resources\Scholarship;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        $info =  json_decode($this->profile->information);
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);
        $address = ['name' =>  (property_exists($info->address, 'name2')) ? $info->address->name2 : $info->address->municipality, 'is_migrated' => 0];
        $this->education->courseInfo = ['name' => $info->course];
        
        return [
            'id' => $this->id,
            'code' => $id,
            'lrn' => ($this->lrn == null) ? 'n/a' : $this->lrn,
            'spas_id' => ($this->spas_id == null) ? 'n/a' : $this->spas_id,
            'awarded_year' => $this->awarded_year,
            'program' => $this->program,
            'status' => $this->status,
            'is_completed' => $this->is_completed,
            'is_undergrad' => $this->is_undergrad,
            'profile' => new ProfileResource($this->profile), 
            'address' => ($this->profile->address->region_code != NULL) ? new AddressResource($this->profile->address) : $address,
            'education' =>  new EducationResource($this->education),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
