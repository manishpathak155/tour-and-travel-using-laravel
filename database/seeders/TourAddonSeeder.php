<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TourAddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addons = [
            'Airport Transfer',
            'Travel Insurance',
            'Porter Service',
            'Photography Package',
            'Helicopter Rescue Insurance',
            'Sleeping Bag Rental',
            'Trekking Pole Rental',
            'Single Room Supplement',
        ];

        $now = now();
        $rows = [];

        foreach ($addons as $index => $name) {
            $rows[] = [
                'name' => $name,
                'price' => 0,
                'price_type' => 'per_person',
                'is_active' => true,
                'sort_order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tour_addons')->insert($rows);
    }
}
