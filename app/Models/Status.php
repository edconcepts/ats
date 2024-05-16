<?php

namespace App\Models;

use App\Observers\StatusObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(StatusObserver::class)]
class Status extends Model
{
    use HasFactory;

    protected $guarded = [];


    // relationships
    public function email()
    {
        return $this->hasOne(StatusEmail::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
