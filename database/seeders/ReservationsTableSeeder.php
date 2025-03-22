<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Recurrence;

class ReservationsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::inRandomOrder()->first();
        $recurrence = Recurrence::inRandomOrder()->first();

        Reservation::create([
            'user_id' => $user->id,
            'recurrence_id' => $recurrence->id,
        ]);
    }
}
