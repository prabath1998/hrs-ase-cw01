<?php

namespace Database\Seeders;

use App\Models\OptionalService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OptionalService::firstOrCreate(
            ['name' => 'Airport Transfer - Arrival'],
            [
                'description' => 'One-way airport transfer upon arrival.',
                'price' => 8.00,
                'category' => 'Transport',
                'is_active' => true,
            ]
        );

        OptionalService::firstOrCreate(
            ['name' => 'Buffet Breakfast'],
            [
                'description' => 'Daily buffet breakfast per person.',
                'price' => 6.00,
                'category' => 'Food & Beverage',
                'is_active' => true,
            ]
        );

        OptionalService::firstOrCreate(
            ['name' => 'Laundry Service - 5 Pieces'],
            [
                'description' => 'Laundry service for up to 5 pieces of clothing.',
                'price' => 3.00,
                'category' => 'Amenities',
                'is_active' => true,
            ]
        );

        OptionalService::firstOrCreate(
            ['name' => 'Late Checkout - Until 4 PM'],
            [
                'description' => 'Extend your checkout time until 4:00 PM.',
                'price' => 4.00,
                'category' => 'Room',
                'is_active' => true,
            ]
        );
    }
}
