<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends =[
        'is_hr', 'is_store_manager'
    ];

    // relationships

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(StoreManagerTimeSlot::class);
    }



    // accessors
    public function getIsHrAttribute(): bool
    {
        $isHr = $this->whereRelation('roles','name', 'hr')->count();
        return $isHr;
    }

    public function getIsStoreManagerAttribute(): bool
    {
        $isStoreManager = $this->whereRelation('roles','name', 'store_manager')->count();
        return $isStoreManager;
    }
}
