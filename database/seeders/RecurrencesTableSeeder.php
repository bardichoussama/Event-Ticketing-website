<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recurrence;
use App\Models\Event;
use App\Models\Room;

class RecurrencesTableSeeder extends Seeder
{
    public function run()
    { $events = Event::all(); // Fetch all events
        $rooms = Room::all(); // Fetch all rooms

        if ($events->isEmpty() || $rooms->isEmpty()) {
            return; // Stop if no events or rooms exist
        }

        foreach ($events as $event) {
            $room = $rooms->random(); // Pick a random room for each event

            Recurrence::create([
                'event_id' => $event->id,
                'room_id' => $room->id,
                'event_timestamp' => now()->addDays(rand(1, 30)),
            ]);
        }
    }
}
