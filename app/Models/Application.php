<?php

namespace App\Models;

use App\Contracts\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use \LaravelArchivable\Archivable;

class Application extends Model implements Importable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'kik_date' => 'datetime:Y-m-d H:00',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
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
        return $this->hasOne(Interview::class);
    }

    public function routeNotificationForVonage(Notification $notification): string
    {
        $this->phone = str_replace(' ', '', $this->phone_number);

        if (
            (str_starts_with($this->phone_number, '+31') && strlen($this->phone_number) === 12) ||
            (str_starts_with($this->phone_number, '31') && strlen($this->phone_number) === 11)
        ) {
            return str_replace('+', '', $this->phone_number);
        }

        if (str_starts_with($this->phone_number, '06') && strlen($this->phone_number) === 10) {
            return '31' . substr($this->phone_number, 1);
        }

        throw new \Exception('Invalid phone number');
    }

}
