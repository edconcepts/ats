<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model implements Importable
{
    use HasFactory;

    protected $guarded = [];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class, 'location_id','kik_id');
    }

    public function applications()
    {
        return $this->throughVacancies()->hasApplications();
    }

    public function manager(): HasOne
    {
        return $this->hasOne(User::class, 'location_id');
    }
}
