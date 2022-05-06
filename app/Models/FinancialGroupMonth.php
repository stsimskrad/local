<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGroupMonth extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->belongsTo('App\Models\FinancialGroup', 'group_id', 'id');
    }

    public function releases()
    {
        return $this->hasMany('App\Models\FinancialGroupMonthRelease', 'month_id')->orderBy('created_at','DESC');
    } 

    public function getMonthAttribute($value)
    {
        return date('F', strtotime($value));
    }
}
