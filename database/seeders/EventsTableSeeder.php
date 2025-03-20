<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch categories from the database and create a mapping
        $categories = Category::all()->keyBy('name');

        $events = [
            [
                'title' => 'International Music & Arts Festival',
                'description' => 'Join the biggest music and arts festival of the year with artists, musicians, and performers from all over the world.',
                'image' => 'music-arts-festival.jpg',
                'address' => 'Central Park, London',
                'category' => 'Music'
            ],
            [
                'title' => 'Global Education & Innovation Summit 2025',
                'description' => 'A prestigious event bringing together global education leaders, researchers, and students to discuss the future of education and technology.',
                'image' => 'education-summit.jpg',
                'address' => 'University Hall, New York',
                'category' => 'Education'
            ],
            [
                'title' => 'Tech Future Expo & Startup Conference',
                'description' => 'A must-attend event for tech enthusiasts, startups, and investors looking to explore the latest innovations in AI, blockchain, and green tech.',
                'image' => 'tech-future-expo.jpg',
                'address' => 'Tech Park, San Francisco',
                'category' => 'Technology'
            ],
            [
                'title' => 'Broadway Live: A Night of Theater Excellence',
                'description' => 'An exclusive night of performances featuring Broadway’s finest talent and new upcoming theater stars.',
                'image' => 'theater-night.jpg',
                'address' => 'Broadway Hall, New York',
                'category' => 'Theater'
            ],
            [
                'title' => 'National Sports Championship 2025',
                'description' => 'Experience thrilling sports action as national teams compete for the championship title.',
                'image' => 'sports-championship.jpg',
                'address' => 'National Stadium, Los Angeles',
                'category' => 'Sports'
            ],
        ];

        foreach ($events as $eventData) {
            // Find the correct category based on the event
            $category = $categories[$eventData['category']] ?? null;

            if ($category) {
                Event::create([
                    'title' => $eventData['title'],
                    'description' => $eventData['description'],
                    'image' => $eventData['image'],
                    'address' => $eventData['address'],
                    'category_id' => $category->id,
                    'regular_price' => rand(100, 300),
                    'discount_price' => rand(30, 80),
                ]);
            }
        }
    }
}
