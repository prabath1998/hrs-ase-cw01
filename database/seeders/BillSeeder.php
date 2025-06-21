<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservation = Reservation::find(1);
        $reservation->bills()->create([
            'amount' => 100.00,
            'status' => 'paid',
            'payment_method' => 'credit_card',
            'paid_at' => now(),
            'created_by_user_id' => 1,
        ]);
    }
}
