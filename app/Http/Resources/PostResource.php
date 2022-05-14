<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'attachment' => $this->attachment,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'start_at' => $this->start_at,
            'firstname' => $this->user->profile->firstname,
            'lastname' => $this->user->profile->lastname,
            'middlename' => $this->user->profile->middlename
        ];
    }
}
