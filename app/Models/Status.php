<?php

namespace App\Models;

use App\Traits\HasOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Status extends Model
{
    // TODO: Consider visible scope
    use HasFactory,
        HasOrder;

    protected $fillable = [
        'name', 'visible', 'order',
    ];

    // Relationships
    public function email(): HasOne
    {
        return $this->hasOne(StatusEmail::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
