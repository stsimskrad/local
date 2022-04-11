<?php

namespace App\Http\Resources\Evaluation;

use Illuminate\Http\Resources\Json\JsonResource;

class FailedResource extends JsonResource
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
            'code' => $this->code,
            'subject' => $this->subject,
            'school_id' => $this->enrollment->scholar->school->school->school->id,
            'school_name' => $this->enrollment->scholar->school->school->school->name
        ];
    }
}
