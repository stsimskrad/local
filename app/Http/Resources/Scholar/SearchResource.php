<?php

namespace App\Http\Resources\Scholar;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'code' => $id,
            'awarded_year' => $this->awarded_year,
            'avatar' => $this->profile->avatar,
            'firstname' => strtoupper($this->profile->firstname),
            'lastname' => strtoupper($this->profile->lastname),
            'middlename' => strtoupper($this->profile->middlename),
            'suffix' => $this->profile->suffix,
            'status' => $this->status,
            'school' => $this->school->school->school->name,
            'year' => $this->school->level,
            'course' => ($this->school->subcourse) ? $this->school->subcourse->years : 'n/a'
        ];
    }
}
