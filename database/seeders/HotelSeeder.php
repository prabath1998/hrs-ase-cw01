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
            ['name' => 'Sunset Galle Fort'],
            [
                'address' => 'Galle City, Galle (Old Town), Sri Lanka',
                'contact_email' => 'hotel1@example.com',
                'phone_number' => '+94 91 222 3333',
                'images' => json_encode([
                    asset('images/hotel/1/83871748.jpg'),
                    asset('images/hotel/1/84220869.jpg'),
                    asset('images/hotel/1/86161620.jpg'),
                    asset('images/hotel/1/86161663.jpg'),
                ]),
                'description' => 'A beautiful hotel located in the heart of Galle Fort, offering stunning views and luxurious amenities.',
                'website' => 'https://sunsetgallefort.com',
                'rating' => 4.5,
                'default_check_in_time' => now()->setTime(14, 0, 0)->format('Y-m-d H:i:s'),
                'default_check_out_time' => now()->setTime(12, 0, 0)->format('Y-m-d H:i:s'),
            ]
        );

        Hotel::firstOrCreate(
            ['name' => 'Sheraton Colombo Hotel'],
            [
                'address' => '265 Galle Road, Kollupitiya, Kollupitiya, 00300 Colombo, Sri Lanka',
                'contact_email' => 'hotel2@example.com',
                'phone_number' => '+94 91 222 3333',
                'images' => json_encode([
                    asset('images/hotel/2/522468660.jpg'),
                    asset('images/hotel/2/544295993.jpg'),
                    asset('images/hotel/2/544296078.jpg'),
                    asset('images/hotel/2/544317721.jpg'),
                    asset('images/hotel/2/544334152.jpg'),
                ]),
                'description' => 'A luxurious hotel in Colombo with modern amenities and exceptional service.',
                'website' => 'https://sheratoncolombo.com',
                'rating' => 4.7,
                'default_check_in_time' => now()->setTime(15, 0, 0)->format('Y-m-d H:i:s'),
                'default_check_out_time' => now()->setTime(11, 0, 0)->format('Y-m-d H:i:s'),
            ]
        );

        Hotel::firstOrCreate(
            ['name' => 'Cinnamon Lakeside'],
            [
                'address' => '115,Sir Chittampalam A,Gardiner Mawatha, Fort, 00100 Colombo, Sri Lanka',
                'contact_email' => 'hotel3@texample.com',
                'phone_number' => '+94 91 222 3333',
                'images' => json_encode([
                    asset('images/hotel/3/64394922.jpg'),
                    asset('images/hotel/3/112518665.jpg'),
                    asset('images/hotel/3/647785366.jpg'),
                    asset('images/hotel/3/647785414.jpg'),
                    asset('images/hotel/3/647785431.jpg'),
                ]),
                'description' => 'Cinnamon Lakeside is a luxury hotel located in Colombo, offering a serene lakeside experience with top-notch amenities.',
                'website' => 'https://cinnamonlakeside.com',
                'rating' => 4.8,
                'default_check_in_time' => now()->setTime(14, 0, 0)->format('Y-m-d H:i:s'),
                'default_check_out_time' => now()->setTime(12, 0, 0)->format('Y-m-d H:i:s'),
            ]
        );

    }
}
