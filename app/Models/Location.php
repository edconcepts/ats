<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
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
}
