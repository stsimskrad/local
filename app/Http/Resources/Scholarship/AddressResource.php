<?php

namespace App\Http\Resources\Scholarship;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'name' => $this->municipality->name.', '.$this->municipality->province->name,
            'region' => $this->region,
            'province' => $this->province,
            'municipality' => $this->municipality,
            'is_migrated' => 1
        ];
    }
}


