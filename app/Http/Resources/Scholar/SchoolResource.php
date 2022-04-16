<?php

namespace App\Http\Resources\Scholar;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'name' => $this->school->name,
            'avatar' => $this->school->avatar,
            'shortcut' => $this->shortcut,
            'campus' => $this->campus,
            'address' => ucwords($this->address)
        ];

        return parent::toArray($request);
    }
}
