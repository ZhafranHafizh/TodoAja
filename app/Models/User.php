<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pin',
        'is_active',
        'pin_generated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pin_generated_at' => 'datetime',
        ];
    }

    /**
     * Generate a random 4-digit PIN
     */
    public function generatePin(): string
    {
        $pin = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $this->update([
            'pin' => $pin,
            'pin_generated_at' => now(),
        ]);
        return $pin;
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
