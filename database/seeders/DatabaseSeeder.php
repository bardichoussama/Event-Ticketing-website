<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            EventsTableSeeder::class,
            RoomsTableSeeder::class,
            RecurrencesTableSeeder::class,
            ReservationsTableSeeder::class,
            TicketsTableSeeder::class,
        ]);
    }
}

