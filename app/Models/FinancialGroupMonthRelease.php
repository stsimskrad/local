<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialGroupMonthRelease extends Model
{
    use HasFactory;

    protected $fillable = [
        'month_id', 'dv_no', 'number', 'added_by', 'attachment'
    ];

    public function month()
    {
        return $this->belongsTo('App\Models\FinancialGroupMonth', 'month_id', 'id');
    }

    public function scholars()
    {
        return $this->hasMany('App\Models\FinancialGroupMonthReleaseScholar', 'release_id');
    } 

    public function scholarsCount()
    {
        return $this->hasMany('App\Models\FinancialGroupMonthReleaseScholar', 'release_id')->count();
    } 

    public function scholarsTotal()
    {
        return $this->hasMany('App\Models\FinancialGroupMonthReleaseScholar', 'release_id')->sum('total');
    } 

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
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
