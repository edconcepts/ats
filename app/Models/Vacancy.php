<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    //relationships
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'kik_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'vacancy_id', 'kik_id');
    }
}
