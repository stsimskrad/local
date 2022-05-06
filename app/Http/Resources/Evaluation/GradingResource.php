<?php

namespace App\Http\Resources\Evaluation;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Scholar\SchoolResource;
use App\Http\Resources\Scholar\ProfileResource;

class GradingResource extends JsonResource
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
            'id' => $this->id,
            'spas_id' => $this->spas_id,
            'awarded_year' => $this->awarded_year,
            'profile' => new ProfileResource($this->profile),
            'status' => $this->status,   
            'school' => new SchoolResource($this->education->school),
            'course' => ($this->education->course) ? new CourseResource($this->education) : '',
            'enrollments' => EnrollmentResource::collection($this->enrollments)
        ];
    }
}


// 'id' => $this->id,
// 'level' => $this->level,
// 'avatar' => $this->profile->avatar,
// 'firstname' => $this->profile->firstname,
// 'middlename' => $this->profile->middlename,
// 'lastname' => $this->profile->lastname,
// 'suffix' => $this->profile->suffix,
// 'color' => $this->status->color,
// 'name' => $this->status->name,
// 'school' => new SearchResource($this->school),
// 'course' => $this->course,
// 'subcourse' => $this->subcourse,
// 'enrollments' => EnrollmentResource::collection($this->enrollments),