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

        $reservation1->optionalServices()->attach([1, 2], ['quantity' => 1]); // Attach optional services with quantity

        // Create another reservation for a customer with ID 2
        $reservation2 = Reservation::create([
            'customer_id' => 2,
            'room_id' => 2,
            'hotel_id' => 1,
            'room_type_id' => 2,
            'check_in_date' => '2023-07-01',
            'check_out_date' => '2023-07-03',
            'number_of_guests' => 1,
            'status' => 'pending',
            'has_credit_card_guarantee' => false,
            'booked_by_user_id' => 2,
            'total_estimated_room_charge' => 60.00,
        ]);

        $reservation2->optionalServices()->attach([3], ['quantity' => 2]); // Attach optional services with quantity

        // Create a reservation for a customer with ID 3
        $reservation3 = Reservation::create([
            'customer_id' => 3,
            'room_id' => 3,
            'hotel_id' => 1,
            'room_type_id' => 3,
            'check_in_date' => '2023-08-01',
            'check_out_date' => '2023-08-07',
            'number_of_guests' => 4,
            'status' => 'checked_in',
            'has_credit_card_guarantee' => true,
            'booked_by_user_id' => 1,
            'total_estimated_room_charge' => 280.00,
        ]);

        $reservation3->optionalServices()->attach([1, 2, 3], ['quantity' => 1]); // Attach optional services with quantity
    }
}
