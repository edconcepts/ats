<?php

namespace App\Models;

use App\Contracts\Importable;
use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class Application extends Model implements Importable
{
    use HasFactory,
        Notifiable,
        SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'kik_date' => 'datetime:Y-m-d H:00',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Relationships
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
        $phone = FormatHelper::formatPhoneNumber($this->phone_number);

        if (! is_null($phone)) {
            return $phone;
        }

        throw new \Exception('Invalid phone number');
    }

}
