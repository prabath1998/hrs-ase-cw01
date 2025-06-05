<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a reservation for a customer with ID 1
        $reservation1 = Reservation::create([
            'customer_id' => 1,
            'room_id' => 1,
            'hotel_id' => 1,
            'room_type_id' => 1,
            'check_in_date' => '2023-06-01',
            'check_out_date' => '2023-06-05',
            'number_of_guests' => 2,
            'status' => 'confirmed',
            'has_credit_card_guarantee' => true,
            'booked_by_user_id' => 1,
            'total_estimated_room_charge' => 100.00,
        ]);
    }
}
