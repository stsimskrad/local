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
            'id' => ($this->school) ? $this->school->school->id: 'n/a',
            'name' => ($this->school) ? $this->school->school->name: 'n/a',
            'avatar' => ($this->school) ?$this->school->school->avatar: '',
            'shortcut' => ($this->school) ? $this->school->shortcut: '',
            'campus' => ($this->school) ? $this->school->campus: '',
            'is_main' => ($this->school) ? $this->school->is_main : '',
            'address' => ($this->school) ? ucwords($this->school->address) : ''
        ];
    }
}
