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
                'address' => 'Galle City, Galle (Old Town)',
                'contact_email' => 'TlW4t@example.com',
                'phone_number' => '+94 91 222 3333',
                'images' => json_encode([
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/83871748.jpg?k=1a0a78d60f129c5a6e29d1189ab6d9a174288ba270a4f9ff977b4d0a6977d58b&o=',
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/84220869.jpg?k=d61f93267dc7680385f9898e3cf8e8eff91a99449192f7c63fa45e6364421277&o=&hp=1',
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/86161620.jpg?k=08dc11fbb4e510d74712530d0b9f1b6b0b7c13923607279514ab27b2dabded97&o=&hp=1',
                    'https://cf.bstatic.com/xdata/images/hotel/max1024x768/86161663.jpg?k=ee5bd60f7ffdf9ff7b368dbd0e350dd61ab61baa7b503f531c8029febc64ff2b&o=&hp=1',
                ]),
                'description' => 'A beautiful hotel located in the heart of Galle Fort, offering stunning views and luxurious amenities.',
                'website' => 'https://sunsetgallefort.com',
                'rating' => 4.5,
                'default_check_in_time' => now()->setTime(14, 0, 0)->format('Y-m-d H:i:s'),
                'default_check_out_time' => now()->setTime(12, 0, 0)->format('Y-m-d H:i:s'),
            ]
        );


    }
}
