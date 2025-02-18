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
                'title' => 'Sample Event',
                'category_id' => $category->id,  // Assuming you added a categories table
                'regular_price' => 100.00,
                'discount_price' => 80.00,
            ]);
        }
    }
}
