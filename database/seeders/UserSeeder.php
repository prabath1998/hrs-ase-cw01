<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Hotel;
use App\Models\TravelCompany;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::insert([
        //     [
        //         'name' => 'Super Admin',
        //         'email' => 'superadmin@example.com',
        //         'username' => 'superadmin',
        //         'password' => Hash::make('12345678'),
        //     ],
        //     [
        //         'name' => 'Subscriber',
        //         'email' => 'subscriber@example.com',
        //         'username' => 'subscriber',
        //         'password' => Hash::make('12345678'),
        //     ],
        // ]);

        // // Run factory to create additional users with unique details.
        // User::factory()->count(10)->create();
        // $this->command->info('Users table seeded with 10 users!');




        $defaultPassword = Hash::make('password');
        $hotel = Hotel::find(1);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'System Administrator',
                'username' => 'admin',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
                'hotel_id' => null // Admins are not associated with a specific hotel
            ]
        );
        $admin->assignRole('Superadmin');

        // Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@hotel.com'],
            [
                'name' => 'Hotel Manager',
                'username' => 'manager',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
                'hotel_id' => $hotel->id
            ]
        );
        $manager->assignRole('Manager');

        // Reservation Clerk
        $clerk = User::firstOrCreate(
            ['email' => 'clerk@hotel.com'],
            [
                'name' => 'Reservation Clerk',
                'username' => 'clerk',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
                'hotel_id' => $hotel->id
            ]
        );
        $clerk->assignRole('Clerk');

        // Customer
        $customerUser = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Doe',
                'username' => 'customer',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
                'hotel_id' => $hotel->id
            ]
        );
        $customerUser->assignRole('Customer');
        Customer::firstOrCreate(
            ['user_id' => $customerUser->id],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'contact_email' => 'customer@example.com',
                'phone_number' => '0771234567'
            ]
        );


        // Travel Company
        $travelUser = User::firstOrCreate(
            ['email' => 'travel@example.com'],
            [
                'name' => 'Travel Agent Contact',
                'username' => 'travel_agent',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
                'hotel_id' => $hotel->id
            ]
        );
        $travelUser->assignRole('Travel Company');
        TravelCompany::firstOrCreate(
            ['user_id' => $travelUser->id],
            [
                'company_name' => 'Example Travels Ltd.',
                'contact_email' => 'travel@example.com',
                'phone_number' => '0112345678',
                'negotiated_discount_percentage' => 10.00
            ]
        );
    }
}
