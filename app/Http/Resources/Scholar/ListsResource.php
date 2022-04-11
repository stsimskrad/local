<?php

namespace App\Http\Resources\Scholar;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class ListsResource extends JsonResource
{
    public function toArray($request)
    {
        $info =  json_decode($this->profile->information);
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);

        $address = ['name' => (is_array($info->address)) ? $info->address->name2 : $info->address, 'is_migrated' => 0];
        $course = ['name' => $info->course];
        
        return [
            'id' => $this->id,
            'code' => $id,
            'lrn' => ($this->lrn == null) ? 'n/a' : $this->lrn,
            'spas_id' => ($this->spas_id == null) ? 'n/a' : $this->spas_id,
            'awarded_year' => $this->awarded_year,
            'category' => $this->category,
            'status' => $this->status,
            'is_completed' => $this->is_completed,
            'is_undergrad' => $this->is_undergrad,
            'profile' => new ProfileResource($this->profile),   
            'address' => ($this->address) ? new AddressResource($this->address) : $address,
            'school' => new SchoolResource($this->school),
            'course' => ($this->school->course) ? new CourseResource($this->school) : $course,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
