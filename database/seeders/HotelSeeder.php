<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hotel::firstOrCreate(
            ['name' => 'Hotel A'],
            [
                'address' => '123 Main St, City, Country',
                'contact_email' => 'LX7oC@example.com',
                'phone_number' => '123-456-7890',
                'default_check_in_time' => now()->setTime(14, 0, 0)->format('Y-m-d H:i:s'),
                'default_check_out_time' => now()->setTime(12, 0, 0)->format('Y-m-d H:i:s'),
            ]
        );
    }
}
