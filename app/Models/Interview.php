<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    use HasFactory;

    protected $guarded = [];

    //relationships
    public function storeManagerTimeSlot(): BelongsTo
    {
        return $this->belongsTo(StoreManagerTimeSlot::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    //scopes
    public function scopeEnded(Builder $query): Builder
    {
        return $query->whereHas(
            'StoreManagerTimeSlot',
            fn ($query) => $query->where('start' , '<' , now()->subHour())
        );
    }
}
