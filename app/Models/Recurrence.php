<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurrence extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'room_code', 'event_timestamp'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

}
