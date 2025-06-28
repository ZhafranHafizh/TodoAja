<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'start_time',
        'end_time',
        'duration',
    ];

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
