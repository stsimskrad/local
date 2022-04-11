<?php

namespace App\Http\Resources\Accounting;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class DisbursementResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('wew',10);
        $id = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'c' => $id,
            'expense_id' => $this->expense,
            'added_by' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
            'amount' => $this->amount,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
