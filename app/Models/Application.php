<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model implements Importable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'kik_date' => 'datetime:Y-m-d H:00',
    ];

    protected static function booted()
    {
        static::creating(function(Application $application){
            $status = Status::where('name',$application->kik_application_status)->first();
            if($status){
                $application->status_id = $status->id;
            }

            // $application->update(['status_id' => 1]);

        });
    }
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
