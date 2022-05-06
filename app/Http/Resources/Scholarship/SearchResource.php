<?php

namespace App\Http\Resources\Scholarship;

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
            'avatar' => $this->profile->user->avatar,
            'firstname' => strtoupper($this->profile->firstname),
            'lastname' => strtoupper($this->profile->lastname),
            'middlename' => strtoupper($this->profile->middlename),
            'suffix' => $this->profile->suffix,
            'status' => $this->status,
            'school' => $this->education->school->school->name,
            'year' => $this->education->level,
            'course' => ($this->education->subcourse) ? $this->education->subcourse->years : 'n/a'
        ];
    }
}
