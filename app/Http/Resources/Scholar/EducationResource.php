<?php

namespace App\Http\Resources\Scholar;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'school' => ($this->school == null) ? 'n/a' : new SchoolResource($this->school),
            'level' => ($this->level == null) ? 'n/a' : $this->level,
            'course' => ($this->course == null) ? $this->courseInfo['name'] : $this->course,
            'has_school' => ($this->school == null) ? false : true,
            'has_level' => ($this->level == null) ? false : true,
            'has_course' => ($this->course == null) ? false : true,
            'has_subcourse' => ($this->subcourse == null) ? false : true,
        ];
    }
}
