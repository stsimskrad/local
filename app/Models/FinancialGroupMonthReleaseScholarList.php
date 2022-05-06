<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGroupMonthReleaseScholarList extends Model
{
    use HasFactory;

    public function scholar()
    {
        return $this->belongsTo('App\Models\FinancialGroupMonthReleaseScholar', 'scholar_id', 'id');
    }

    public function benefit()
    {
        return $this->belongsTo('App\Models\ListBenefit', 'benefit_id', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
