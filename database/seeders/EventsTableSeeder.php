<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $category = Category::inRandomOrder()->first(); // Get a random category

        if ($category) {
            Event::create([
                'title' => 'Marrakech Food Festival',
                'description' => 'This is a sample event description.',
                'image' => 'sample-event.jpg', // Make sure this path is accessible
                'address' => '123 Event Street, City',
                'category_id' => $category->id,
                'regular_price' => 100.00,
                'discount_price' => 80.00,
            ]);
        }
    }
}
