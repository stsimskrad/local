<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGroupMonthReleaseScholar extends Model
{
    use HasFactory;
    protected $fillable = [
        'release_id', 'scholar_id', 'total'
    ];

    public function release()
    {
        return $this->belongsTo('App\Models\FinancialGroupMonthRelease', 'release_id', 'id');
    }

    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\FinancialGroupMonthReleaseScholarList', 'scholar_id');
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
