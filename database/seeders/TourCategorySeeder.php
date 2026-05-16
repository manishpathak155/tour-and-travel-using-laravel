<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TourCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Trekking & Hiking',
            'Peak Climbing',
            'Cultural Tours',
            'Adventure Sports',
            'Wildlife & Nature',
            'Luxury Tours',
            'Day Tours',
            'Multi-Day Packages',
            'Honeymoon Packages',
            'Corporate & MICE',
            'Helicopter Tours',
            'Mountain Flights',
            'River Rafting',
            'Jungle Safari',
            'Pilgrimage Tours',
        ];

        $now = now();
        $rows = [];

        foreach ($categories as $index => $name) {
            $rows[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tour_categories')->insert($rows);
    }
}
