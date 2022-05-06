<?php

namespace App\Http\Resources\Scholarship\Sub;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthResource extends JsonResource
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
            'month' => $this->month,
            'group_id' => $this->group_id,
            'academic_year' => $this->group->academic_year,
            'semester' => $this->group->semester->name,
            'is_regular' => $this->group->is_regular,
            'releases' => ReleaseResource::collection($this->releases)
        ];
    }
}
