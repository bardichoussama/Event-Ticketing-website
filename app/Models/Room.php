<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function recurrences()
    {
        return $this->hasMany(Recurrence::class, 'room_id'); // Fix here (was 'room_code')
    }
}
