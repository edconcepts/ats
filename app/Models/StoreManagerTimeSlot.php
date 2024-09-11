<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class StoreManagerTimeSlot extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start' => 'datetime',
    ];

    public function storeManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function start(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Carbon::parse($value)->format('D d-m-Y H:i');
            },
        );
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function interview(): HasOne
    {
        return $this->hasOne(Interview::class);
    }
}
