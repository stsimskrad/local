<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;
use Hashids\Hashids;

class AllotmentResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('wew',10);
        $id = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'c' => $id,
            'total' => $this->total(),
            'code' => $this->code,
            'check_no' => $this->check_no,
            'checked_at' => $this->checked_at,
            'credited_at' => $this->credited_at,
            'checked_view' => date('M d, Y', strtotime($this->checked_at)),
            'credited_view' => date('M d, Y', strtotime($this->credited_at)),
            'remarks' => $this->remarks,
            'lists' => $this->lists,
            'added_by' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
