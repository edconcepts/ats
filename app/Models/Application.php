<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \LaravelArchivable\Archivable;

class Application extends Model implements Importable
{
    use HasFactory, Archivable;

    protected $guarded = [];

    protected $casts = [
        'kik_date' => 'datetime:Y-m-d H:00',
    ];

    //relationships

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'kik_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function interview()
    {
        return $this->hasOne(interview::class);
    }
}
