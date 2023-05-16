<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = [];


    // relationships
    public function emails()
    {
        return $this->hasOne(StatusEmail::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
