<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
}
