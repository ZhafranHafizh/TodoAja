<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityReminder extends Model
{
    protected $fillable = [
        'activity_id',
        'reminder_type',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
