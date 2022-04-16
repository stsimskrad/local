<?php

namespace App\Http\Resources\Scholar;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'email' => $this->email,
            'avatar' => ($this->user) ? $this->user->avatar : 'avatar.jpg',
            'gender' => $this->gender,
            'firstname' => strtoupper($this->firstname),
            'middlename' => strtoupper($this->middlename),
            'lastname' =>strtoupper( $this->lastname),
            'birthday' => ($this->birthday == null) ? '' : $this->birthday,
            'suffix' => ($this->suffix == null) ? '' : $this->suffix,
            'gender' => ($this->gender == null) ? '' : $this->gender,
            'mobile' => ($this->mobile == null) ? 'n/a' : $this->mobile,
        ];
    }
}
