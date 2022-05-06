<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class ScholarResource extends JsonResource
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
            'awarded_year' => $this->awarded_year,
            'no' => '-',
            'name' => ucwords(strtolower($this->profile->lastname.', '.$this->profile->firstname.' '.$this->profile->middlename)),
            'level' => $this->education->level->name,
            'school' => ($this->education->school) ? $this->education->school->shortcut : 'n/a',
            'course' => ($this->education->course) ? $this->education->course->abbreviation : 'n/a',
            'award' => ($this->education->award) ? $this->education->award->name : 'n/a',
            'started' => 'January',
            'status' => $this->status->name,
            'program' => $this->program->name
        ];
    }
}
