<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarCourse extends Model
{
    use HasFactory;

    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }

    public function subcourse()
    {
        return $this->belongsTo('App\Models\SchoolCourse', 'subcourse_id', 'id');
    }
}
