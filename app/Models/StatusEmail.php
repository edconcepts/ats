<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusEmail extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relationships
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
