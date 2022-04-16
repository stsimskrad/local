<?php

namespace App\Http\Resources;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class QualifierResource extends JsonResource
{
    public function toArray($request)
    {
        $info =  json_decode($this->profile->information);
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $code,
            'spas_id' => $this->spas_id,
            'lrn' => ($this->lrn == null) ? 'n/a' : $this->lrn,
            'category_id' => $this->category,
            'is_undergrad' => $this->is_undergrad,
            'year' => $this->year,
            'profile_id' => $this->profile->id,
            'avatar' => 'avatar.jpg',
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'middlename' => $this->profile->middlename,
            'suffix' => $this->profile->suffix,
            'gender' => $this->profile->gender,
            // 'gender' => ($this->profile->gender == 0) ? 'Female' : 'Male',
            'mobile' => $this->profile->mobile,
            'email' => $this->profile->email,
            'birthday' => $this->profile->birthday,
            'birth_place' => ucwords(strtolower($info->birth_place)),
            'course' => $info->course,
            'school' => $info->school,
            'barangay' => $info->address->barangay,
            'municipality' => $info->address->municipality,
            'province' => $info->address->province,
            'info' => json_decode($this->profile->information),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
