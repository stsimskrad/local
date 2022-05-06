<?php

namespace App\Http\Resources\Scholarship;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialResource extends JsonResource
{
    public function toArray($request)
    {
        $info =  json_decode($this->profile->information);
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);

        $this->education->addressInfo = ['name' => (is_array($info->address)) ? $info->address->name2 : $info->address, 'is_migrated' => 0];
        $this->education->courseInfo = ['name' => $info->course];
        
        return [
            'id' => $this->id,
            'code' => $id,
            'spas_id' => ($this->spas_id == null) ? 'n/a' : $this->spas_id,
            'awarded_year' => $this->awarded_year,
            'status' => $this->status,
            'profile' => new ProfileResource($this->profile), 
            'education' =>  new EducationResource($this->education),
        ];
    }
}
