<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model implements Importable
{
    use HasFactory;

    protected $guarded = [];


    //relationships

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'kik_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
