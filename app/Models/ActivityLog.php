<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'activity_id',
        'action',
        'logged_at',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
