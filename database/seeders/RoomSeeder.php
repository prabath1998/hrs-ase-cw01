<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standardSingle = RoomType::where('name', 'Standard Single')->first();
        $deluxeDouble = RoomType::where('name', 'Deluxe Double')->first();
        $familySuite = RoomType::where('name', 'Family Suite')->first();
        $executiveSuite = RoomType::where('name', 'Executive Suite')->first();
        $hotel = Hotel::find(1);

        if ($standardSingle) {
            Room::firstOrCreate(['room_number' => '101'], ['room_type_id' => $standardSingle->id, 'floor' => 1, 'status' => 'available', 'features' => ['Air Conditioning', 'Private Bathroom'], 'hotel_id' => $hotel->id ]);
            Room::firstOrCreate(['room_number' => '102'], ['room_type_id' => $standardSingle->id, 'floor' => 1, 'status' => 'available', 'hotel_id' => $hotel->id ]);
        }

        if ($deluxeDouble) {
            Room::firstOrCreate(['room_number' => '201'], ['room_type_id' => $deluxeDouble->id, 'floor' => 2, 'status' => 'available', 'features' => ['Air Conditioning', 'Flat Screen TV', 'Minibar', 'Private Bathroom'], 'hotel_id' => $hotel->id]);
            Room::firstOrCreate(['room_number' => '202'], ['room_type_id' => $deluxeDouble->id, 'floor' => 2, 'status' => 'maintenance', 'hotel_id' => $hotel->id ]);
        }

        if ($familySuite) {
            Room::firstOrCreate(['room_number' => '301-FS'], ['room_type_id' => $familySuite->id, 'floor' => 3, 'status' => 'available', 'features' => ['Air Conditioning', 'Flat Screen TV', 'Balcony', 'Minibar', 'Private Bathroom'], 'hotel_id' => $hotel->id]);
        }

        if ($executiveSuite) {
            Room::firstOrCreate(['room_number' => '401-ES'], ['room_type_id' => $executiveSuite->id, 'floor' => 4, 'status' => 'available', 'features' => ['Air Conditioning', 'Flat Screen TV', 'Balcony', 'Minibar', 'Private Bathroom'], 'hotel_id' => $hotel->id]);
            Room::firstOrCreate(['room_number' => '402-ES'], ['room_type_id' => $executiveSuite->id, 'floor' => 4, 'status' => 'available', 'hotel_id' => $hotel->id ]);
        }
    }
}
