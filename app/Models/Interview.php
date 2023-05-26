<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $guarded = [];

    //relationships
    public function storeManagerTimeSlot()
    {
        return $this->belongsTo(StoreManagerTimeSlot::class);
    }
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    //scopes
    public function scopeEnded(Builder $query)
    {
        $query->whereHas('StoreManagerTimeSlot', function($query){
            return $query->where('to_date_time' , '<' , now());
        });
    }
}
