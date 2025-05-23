<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Permissions
        $permissions = [
            // User Management (Admin)
            'manage_users',
            'manage_roles',
            'manage_permissions',

            // Customer Management (Clerk, Manager)
            'manage_customers',
            'view_customers',
            'create_customers',
            'edit_customers',

            // Travel Company Management (Admin)
            'manage_travel_companies',
            'view_travel_companies',
            'create_travel_companies',
            'edit_travel_companies',

            // Room Management (Clerk, Manager, Admin)
            'manage_room_types',
            'manage_rooms',
            'update_room_status',
            'manage_room_pricing',

            // Optional Service Management (Clerk, Manager, Admin)
            'manage_optional_services',
            'manage_optional_service_pricing',

            // Reservation Management
            'make_reservations_customer', // Customer role
            'view_own_reservations_customer',
            'cancel_own_reservations_customer',
            'make_reservations_travel_company', // Travel Company role
            'view_own_reservations_travel_company',
            'cancel_own_reservations_travel_company',
            'manage_reservations', // Clerk role
            'perform_check_in',
            'perform_check_out',

            // Billing & Payments (Clerk, Manager)
            'manage_billing',
            'generate_bills',
            'record_payments',
            'view_own_bills_customer',
            'view_own_invoices_travel_company',

            // Reporting (Manager)
            'view_occupancy_reports',
            'view_revenue_reports',
            'view_financial_reports',
            'view_booking_forecasts',

            // General Admin Access
            'access_admin_panel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Define Roles and Assign Permissions

        // Admin - Has all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // Manager
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $managerRole->givePermissionTo([
            'access_admin_panel',
            'view_occupancy_reports',
            'view_revenue_reports',
            'view_financial_reports',
            'view_booking_forecasts',
            'manage_room_pricing',
            'manage_optional_service_pricing',
            'view_customers',
            'manage_reservations',
            'manage_billing',
        ]);

        // Reservation Clerk
        $clerkRole = Role::firstOrCreate(['name' => 'Clerk', 'guard_name' => 'web']);
        $clerkRole->givePermissionTo([
            'access_admin_panel',
            'manage_customers',
            'view_customers',
            'create_customers',
            'edit_customers',
            'manage_room_types',
            'manage_rooms',
            'update_room_status',
            'manage_optional_services',
            'manage_reservations',
            'perform_check_in',
            'perform_check_out',
            'manage_billing',
            'generate_bills',
            'record_payments',
        ]);

        // Travel Company
        $travelCompanyRole = Role::firstOrCreate(['name' => 'Travel Company', 'guard_name' => 'web']);
        $travelCompanyRole->givePermissionTo([
            'make_reservations_travel_company',
            'view_own_reservations_travel_company',
            'cancel_own_reservations_travel_company',
            'view_own_invoices_travel_company',
        ]);

        // Customer
        $customerRole = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'web']);
        $customerRole->givePermissionTo([
            'make_reservations_customer',
            'view_own_reservations_customer',
            'cancel_own_reservations_customer',
            'view_own_bills_customer',
        ]);
    }
}
