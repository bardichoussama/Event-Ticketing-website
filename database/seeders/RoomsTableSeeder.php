<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        Room::create([
            'description' => 'Main Hall',
            'capacity' => 100
        ]);

        Room::create([
            'description' => 'Conference Room A',
            'capacity' => 50
        ]);

        Room::create([
            'description' => 'VIP Lounge',
            'capacity' => 20
        ]);
    }
}
