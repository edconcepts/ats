<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model implements Importable
{
    use HasFactory,
        SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'location_title',
    ];

    protected $casts = [
        'kik_date' => 'datetime:Y-m-d',
    ];

    // Attributes
    public function locationTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->location->name . ' - ' . $this->title,
        );
    }

    // Relationships
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'kik_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'vacancy_id', 'kik_id');
    }
}
