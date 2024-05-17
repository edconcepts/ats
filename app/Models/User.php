<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
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
        'phone',
        'email',
        'password',
        'location_id',
        'role',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'password',
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

    // relationships

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function timeSlots(): HasMany
    {
        return $this->hasMany(StoreManagerTimeSlot::class);
    }

    public function availableTimeSlots()
    {
        return $this->hasMany(StoreManagerTimeSlot::class)
                ->doesntHave('interview');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    protected function isHR(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->role == 'hr';
            }
        );
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->role == 'admin';
            }
        );
    }

    protected function isStoreManager(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->role == 'store_manager';
            }
        );
    }

    protected function isAreaManager(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->role == 'area_manager';
            }
        );
    }

    /**
     * Route notifications for the Vonage channel.
     * @throws Exception
     */
    public function routeNotificationForVonage(Notification $notification): string
    {
        $this->phone = str_replace(' ', '', $this->phone);

        if (
            (str_starts_with($this->phone, '+31') && strlen($this->phone) === 12) ||
            (str_starts_with($this->phone, '31') && strlen($this->phone) === 11)
        ) {
            return str_replace('+', '', $this->phone);
        }

        if (str_starts_with($this->phone, '06') && strlen($this->phone) === 10) {
            return '31' . substr($this->phone, 1);
        }

        throw new Exception('Invalid phone number');
    }

    public function shouldVerifyTwoFactorAuth(): bool
    {
        return $this->role === 'store_manager';
    }
}
