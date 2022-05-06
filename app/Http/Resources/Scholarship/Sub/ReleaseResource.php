<?php

namespace App\Http\Resources\Scholarship\Sub;

use App\Http\Resources\NameResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReleaseResource extends JsonResource
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
            'number' => $this->number,
            'dv_no' => $this->dv_no,
            'added_by' => new NameResource($this->user),
            'total' => $this->scholarsTotal(),
            'scholars' => $this->scholarsCount(),
            'created_at' => $this->created_at
        ];
    }
}
