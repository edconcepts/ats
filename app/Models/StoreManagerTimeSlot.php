<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreManagerTimeSlot extends Model
{
    use HasFactory;


    // relationships
    public function storeManager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
