<?php

namespace App\Http\Resources\School;

use App\Http\Resources\DefaultResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Hashids\Hashids;

class ViewResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'code' => $code,
            'name' => ucwords(strtolower($this->school->name)),
            'campus' => ucwords(strtolower($this->campus)),
            'address' => ucwords(strtolower($this->address)),
            'municipality' => $this->municipality,
            'class' => $this->school->class,
            'term' => $this->school->term,
            'grading' => $this->school->grading,
            'courses' => CourseResource::collection($this->courses),
            'semesters' => DefaultResource::collection($this->semesters),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
