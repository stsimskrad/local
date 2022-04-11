<?php

namespace App\Http\Resources\Evaluation;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'id' => $this->course->id,
            'name' => $this->course->name,
            'abbreviation' => $this->course->abbreviation,
            'year' => $this->level->name,
            'level' => $this->level,
            'subcourse' => $this->subcourse,
            'information' => $this->information,
            'updated_at' => $this->updated_at
        ];
    }
}
