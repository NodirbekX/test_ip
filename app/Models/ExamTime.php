<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamTime extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
    ];
}
