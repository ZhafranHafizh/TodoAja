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
        'deadline',
        'category_id',
        'user_id',
    ];

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
