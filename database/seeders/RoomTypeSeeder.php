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

        RoomType::create(
            [
                'name' => 'Standard Single',
                'hotel_id' => $hotel->id,
                'description' => 'A comfortable room for a single occupant.',
                'occupancy_limit' => 1,
                'base_price_per_night' => 10.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV'
                ]
            ]
        );

        RoomType::create(
            [
                'name' => 'Deluxe Double',
                'hotel_id' => $hotel->id,
                'description' => 'A spacious room with a double bed, suitable for two.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 16.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Private Bathroom'

                ]
            ]
        );

        RoomType::create(
            [
                'name' => 'Family Suite',
                'hotel_id' => $hotel->id,
                'description' => 'A large suite with multiple beds, ideal for families.',
                'occupancy_limit' => 4,
                'base_price_per_night' => 38.00,
                'is_suite' => true,
                'suite_weekly_rate' => 40.00,
                'suite_monthly_rate' => 50.00,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Minibar', 'Private Bathroom'

                ],
            ]
        );

        RoomType::create(
            [
                'name' => 'Executive Suite',
                'hotel_id' => $hotel->id,
                'description' => 'A luxurious suite with premium amenities and a separate living area.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 70.00,
                'is_suite' => true,
                'suite_weekly_rate' => 80.00,
                'suite_monthly_rate' => 90.00,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Balcony', 'Minibar', 'Private Bathroom'

                ],
            ]
        );

        $hotel = Hotel::find(2);

        RoomType::create(
            [
                'name' => 'Standard Single',
                'hotel_id' => $hotel->id,
                'description' => 'A comfortable room for a single occupant.',
                'occupancy_limit' => 1,
                'base_price_per_night' => 18.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV'
                ]
            ]
        );

        RoomType::create(
            [
                'name' => 'Deluxe Double',
                'hotel_id' => $hotel->id,
                'description' => 'A spacious room with a double bed, suitable for two.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 25.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Private Bathroom'

                ]
            ]
        );

        RoomType::create(
            [
                'name' => 'Executive Suite',
                'hotel_id' => $hotel->id,
                'description' => 'A luxurious suite with premium amenities and a separate living area.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 45.00,
                'is_suite' => true,
                'suite_weekly_rate' => 55.00,
                'suite_monthly_rate' => 70.00,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Balcony', 'Minibar', 'Private Bathroom'

                ],
            ]
        );

        $hotel = Hotel::find(3);

        RoomType::create(
            [
                'name' => 'Standard Single',
                'hotel_id' => $hotel->id,
                'description' => 'A comfortable room for a single occupant.',
                'occupancy_limit' => 1,
                'base_price_per_night' => 16.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV'
                ]
            ]
        );

        RoomType::create(
            [
                'name' => 'Deluxe Double',
                'hotel_id' => $hotel->id,
                'description' => 'A spacious room with a double bed, suitable for two.',
                'occupancy_limit' => 2,
                'base_price_per_night' => 27.00,
                'is_suite' => false,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Private Bathroom'

                ]
            ]
        );

        RoomType::create(
            [
                'name' => 'Family Suite',
                'hotel_id' => $hotel->id,
                'description' => 'A large suite with multiple beds, ideal for families.',
                'occupancy_limit' => 6,
                'base_price_per_night' => 60.00,
                'is_suite' => true,
                'suite_weekly_rate' => 80.00,
                'suite_monthly_rate' => 100.00,
                'features' => [
                    'Air Conditioning', 'Flat Screen TV', 'Free WIFI', 'Minibar', 'Private Bathroom'

                ],
            ]
        );
    }
}
