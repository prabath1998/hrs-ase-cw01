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
            'check_in_date' => '2025-03-01',
            'check_out_date' => '2025-03-05',
            'number_of_guests' => 2,
            'status' => 'confirmed_guaranteed',
            'has_credit_card_guarantee' => true,
            'booked_by_user_id' => 1,
            'total_estimated_room_charge' => 40.00,
        ]);

        $reservation1->optionalServices()->attach([
            1 => ['quantity' => 1, 'price_at_booking' => 8.00],
            2 => ['quantity' => 1, 'price_at_booking' => 6.00],
        ]);

        // Create another reservation for a customer with ID 2
        $reservation2 = Reservation::create([
            'customer_id' => 1,
            'room_id' => 2,
            'hotel_id' => 1,
            'room_type_id' => 2,
            'check_in_date' => '2025-04-01',
            'check_out_date' => '2025-04-03',
            'number_of_guests' => 1,
            'status' => 'pending_confirmation',
            'has_credit_card_guarantee' => false,
            'booked_by_user_id' => 2,
            'total_estimated_room_charge' => 32.00,
        ]);

        $reservation2->optionalServices()->attach([
            3 => ['quantity' => 1, 'price_at_booking' => 3.00],
        ]);

        // Create a reservation for a customer with ID 3
        $reservation3 = Reservation::create([
            'customer_id' => 1,
            'room_id' => 3,
            'hotel_id' => 1,
            'room_type_id' => 3,
            'check_in_date' => '2025-05-01',
            'check_out_date' => '2025-05-07',
            'number_of_guests' => 4,
            'status' => 'checked_in',
            'has_credit_card_guarantee' => true,
            'booked_by_user_id' => 1,
            'total_estimated_room_charge' => 192.00,
            'is_suite_booking' => true,
            'suite_booking_period' => 'weekly',
            'suite_rate_applied' => 40.00
        ]);

        $reservation3->optionalServices()->attach([
            1 => ['quantity' => 1, 'price_at_booking' => 8.00],
            2 => ['quantity' => 1, 'price_at_booking' => 6.00],
            3 => ['quantity' => 1, 'price_at_booking' => 3.00],
        ]);
    }
}
