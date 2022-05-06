<?php

namespace App\Http\Resources\Scholarship;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Scholarship\Sub\SchoolResource;

class EducationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'school' => ($this->school == null) ? 'n/a' : new SchoolResource($this->school),
            'level' => ($this->level == null) ? 'n/a' : $this->level,
            'course' => ($this->course == null) ? $this->courseInfo['name'] : $this->course,
            'subcourse' => $this->subcourse,
            'information' => $this->information, //json_decode
            'has_school' => ($this->school == null) ? false : true,
            'has_level' => ($this->level == null) ? false : true,
            'has_course' => ($this->course == null) ? false : true,
            'has_subcourse' => ($this->subcourse == null) ? false : true,
        ];
    }
}
