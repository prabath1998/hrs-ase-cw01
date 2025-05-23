<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\TravelCompany;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'username' => 'superadmin',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Subscriber',
                'email' => 'subscriber@example.com',
                'username' => 'subscriber',
                'password' => Hash::make('12345678'),
            ],
        ]);

        // Run factory to create additional users with unique details.
        User::factory()->count(500)->create();
        $this->command->info('Users table seeded with 502 users!');




        $defaultPassword = Hash::make('password');

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'System Administrator',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('Admin');

        // Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@hotel.com'],
            [
                'name' => 'Hotel Manager',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]
        );
        $manager->assignRole('Manager');

        // Reservation Clerk
        $clerk = User::firstOrCreate(
            ['email' => 'clerk@hotel.com'],
            [
                'name' => 'Reservation Clerk',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]
        );
        $clerk->assignRole('Clerk');

        // Customer
        $customerUser = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Doe',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
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
                'password' => $defaultPassword,
                'email_verified_at' => now(),
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
