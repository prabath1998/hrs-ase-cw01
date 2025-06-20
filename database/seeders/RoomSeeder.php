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
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            $roomTypes = RoomType::where('hotel_id', $hotel->id)->get();

            foreach ($roomTypes as $roomType) {
                for ($i = 1; $i <= 5; $i++) {
                    $roomNumber = $hotel->id.$roomType->id.str_pad($i, 3, '0', STR_PAD_LEFT);
                    Room::create(
                        [
                            'room_number' => $roomNumber,
                            'room_type_id' => $roomType->id,
                            'floor' => rand(1, 5),
                            'status' => 'available',
                            'features' => json_encode($roomType->features),
                            'hotel_id' => $hotel->id
                        ]
                    );
                }
            }
        }
    }
}
