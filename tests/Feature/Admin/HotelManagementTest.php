<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Tests\TestCase;


class HotelManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Superadmin', 'guard_name' => 'web']);
    }


    public function test_admin_can_create_a_hotel()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Superadmin');

        $response = $this->actingAs($admin)
            ->post('/admin/hotels/store', [
                'name' => 'Luxury Hotel',
                'location' => 'Colombo, Sri Lanka',
            ]);

        $response->assertRedirect('/admin/hotels');

        $this->assertDatabaseHas('hotels', [
            'name' => 'Luxury Hotel',
            'location' => 'Colombo, Sri Lanka',
        ]);
    }
}

