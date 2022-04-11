<?php

namespace App\Http\Resources\Scholar;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\School\ViewResource;
use Hashids\Hashids;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        $info =  json_decode($this->profile->information);
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $id,
            'lrn' => ($this->lrn == null) ? 'n/a' : $this->lrn,
            'spas_id' => ($this->spas_id == null) ? 'n/a' : $this->spas_id,
            'category_id' => $this->category,
            'level' => $this->level,
            'status_id' => $this->status,
            'awarded_year' => $this->awarded_year,
            'avatar' => $this->profile->avatar,
            'email' => ($this->profile->email == null) ? 'n/a' : $this->profile->email,
            'birthday' => $this->profile->birthday,
            'firstname' => strtoupper($this->profile->firstname),
            'lastname' => strtoupper($this->profile->lastname),
            'middlename' => strtoupper($this->profile->middlename),
            'suffix' => $this->profile->suffix,
            'gender' => $this->profile->gender,
            'mobile' => ($this->profile->mobile == null) ? 'n/a' : $this->profile->mobile,
            // 'social' => $info->social,
            'father' => ucwords(strtolower($info->parents->father)),
            'mother' => ucwords(strtolower($info->parents->mother)),
            'birth_place' => ucwords(strtolower($info->birth_place)),
            'course' => ($this->course == null) ? $info->course : $this->course, //$info->course, 
            'school' => ($this->school == null) ? $info->school : $this->school,//$info->school,
            'skool' => ($this->school == null) ? '' : new ViewResource($this->school),//$info->school,
            'barangay' => ($this->address == null) ? 'n/a' : $this->address->barangay, //$info->address->barangay,
            'municipality' => ($this->address == null) ? 'n/a' :$this->address->municipality, //$info->address->municipality,
            'province' => ($this->address == null) ? 'n/a' : $this->address->province,  //$info->address->province,
            'region' => ($this->address == null) ? 'n/a' : $this->address->region,  
            'tempAddress' => ($info->address == null) ? '' : $info->address ,
            'tempLevel' => $info->level,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
