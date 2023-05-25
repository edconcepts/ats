<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Location extends Model implements Importable
{
    use HasFactory;

    //realationships

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'location_id','kik_id');
    }

    public function applications()
    {
        return $this->throughVacancies()->hasApplications();
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }
}
