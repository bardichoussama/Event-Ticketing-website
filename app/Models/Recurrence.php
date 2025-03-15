<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurrence extends Model
{
    use HasFactory;
    protected $table = 'recurrences';
    
    protected $fillable = ['event_id', 'room_id', 'event_timestamp']; // Update 'room_code' to 'room_id'

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id'); // Fix here (was 'room_code')
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
