<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recurrence;
use App\Models\Event;
use App\Models\Room;

class RecurrencesTableSeeder extends Seeder
{
    public function run()
    {
        $event = Event::inRandomOrder()->first();
        $room = Room::inRandomOrder()->first();

        Recurrence::create([
            'event_id' => $event->id,
            'room_code' => $room->id,
            'event_timestamp' => now()->addDays(rand(1, 30)),
        ]);
    }
}
