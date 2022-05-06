<?php

namespace App\Http\Resources\Scholarship;

use Illuminate\Http\Resources\Json\JsonResource;

class TracerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'information' => json_decode($this->information),
            'scholar_id' => $this->scholar_id,
            'added_by' => $this->added_by,
            'created_at' => $this->created_at
        ];
    }
}
