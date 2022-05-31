<?php

namespace App\Http\Resources\Qualifier;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $info = json_decode($this->profile->information);
        $test = ($this->profile->suffix != null) ? $this->profile->suffix.' ' : ''; 
        $this->profile->address->info = ['info' => $info->address];
        return [
            'id' => $this->id,
            'spas_id' => $this->spas_id,
            'avatar' => 'avatar.jpg',
            'name' => $this->profile->lastname.', '.$this->profile->firstname.' '.$test.$this->profile->middlename,
            'is_undergrad' => $this->is_undergrad,
            'is_waiting' => $this->is_waiting,
            'is_referral' => $this->is_referral,
            'is_qualified' => $this->is_qualified,
            'program' => $this->program,
            'profile' => new ProfileResource($this->profile),
            'address' => new AddressResource($this->profile->address),
            'information' => json_decode($this->profile->information,true),
        ];
    }
}
