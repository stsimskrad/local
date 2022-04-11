<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'financial_id' => $this->financial_id,
            'type' => $this->financial->group->release_type,
            'val' => ($this->financial->group->release_type == "Full") ? '<i class="bx bx-check-circle text-success"></i>' : '<i class="bx bx-error-circle text-warning"></i>'
        ];
    }
}
