<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotmentBalance extends Model
{
    use HasFactory;

    public function expense()
    {
        return $this->belongsTo('App\Models\ListExpense', 'expense_id', 'id');
    }
}
