<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotel = Hotel::find(1);

        RoomType::firstOrCreate(
            ['name' => 'Standard Single'],
            [
                'hotel_id' => $hotel->id,
                'description' => 'A comfortable room for a single occupant.',
                'occupancy_limit' => 1,
                'base_price_per_night' => 5000.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV'
                ]
            ]
        );

        RoomType::firstOrCreate(
            ['name' => 'Deluxe Double'],
            [
                'hotel_id' => $hotel->id,
                'description' => 'A spacious room with a double bed, suitable for two.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 10000.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Private Bathroom'

                ]
            ]
        );

        RoomType::firstOrCreate(
            ['name' => 'Family Suite'],
            [
                'hotel_id' => $hotel->id,
                'description' => 'A large suite with multiple beds, ideal for families.',
                'occupancy_limit' => 4,
                'base_price_per_night' => 20000.00,
                'is_suite' => true,
                'suite_weekly_rate' => 100000.00,
                'suite_monthly_rate' => 500000.00,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Minibar', 'Private Bathroom'

                ],
            ]
        );

        RoomType::firstOrCreate(
            ['name' => 'Executive Suite'],
            [
                'hotel_id' => $hotel->id,
                'description' => 'A luxurious suite with premium amenities and a separate living area.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 35000.00,
                'is_suite' => true,
                'suite_weekly_rate' => 200000.00,
                'suite_monthly_rate' => 900000.00,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Balcony', 'Minibar', 'Private Bathroom'

                ],
            ]
        );
    }
}
