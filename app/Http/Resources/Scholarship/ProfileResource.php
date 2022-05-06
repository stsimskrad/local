<?php

namespace App\Http\Resources\Scholarship;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {   
        $info = json_decode($this->information);

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
            'mother' => $info->parents->mother,
            'father' => $info->parents->father
        ];
    }
}
