<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Reservation;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        $reservation = Reservation::inRandomOrder()->first();

        Ticket::create([
            'reservation_id' => $reservation->id,
            'tariff_type' => 'Standard',
            'seat' => rand(1, 500),
        ]);
    }
}
