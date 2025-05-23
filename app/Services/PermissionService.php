<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * Get all permissions organized by groups
     *
     * @return array
     */
    public function getAllPermissions(): array
    {
        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions' => [  // Clerk, Manager, Admin
                    'dashboard.view',
                ],
            ],
            [
                'group_name' => 'user',
                'permissions' => [  // Admin
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                    'user.manage',
                    'user.login_as',
                ],
            ],
            [
                'group_name' => 'customer',
                'permissions' => [ // Clerk, Manager, Admin
                    'customer.create',
                    'customer.view',
                    'customer.edit',
                    'customer.delete',
                    'customer.manage',
                    'customer.login_as',
                ],
            ],
            [
                'group_name' => 'travel_company',
                'permissions' => [  // Admin
                    'travel_company.create',
                    'travel_company.view',
                    'travel_company.edit',
                    'travel_company.delete',
                    'travel_company.manage',
                    'travel_company.login_as',
                ],
            ],
            [
                'group_name' => 'room',
                'permissions' => [  // Clerk, Manager, Admin
                    'room.manage',
                    'room.update_status',
                    'room.update_pricing',
                ],
            ],
            [
                'group_name' => 'room_type',
                'permissions' => [  // Clerk, Manager, Admin
                    'room_type.manage',
                ],
            ],
            [
                'group_name' => 'optional_service',
                'permissions' => [  // Clerk, Manager, Admin
                    'optional_service.manage',
                    'optional_service.update_pricing',
                ],
            ],
            [
                'group_name' => 'reservation',
                'permissions' => [  // Clerk, Manager, Admin
                    'reservation.create',
                    'reservation.view',
                    'reservation.edit',
                    'reservation.delete',
                    'reservation.cancel',
                    'reservation.check_in',
                    'reservation.check_out',
                    'reservation.manage',
                ],
            ],
            [
                'group_name' => 'billing',
                'permissions' => [  // Clerk, Manager, Admin
                    'billing.manage',
                    'billing.generate_bill',
                    'billing.record_payment',
                ],
            ],
            [
                'group_name' => 'reporting',
                'permissions' => [  // Manager, Admin
                    'reporting.view_occupancy_reports',
                    'reporting.view_revenue_reports',
                    'reporting.view_financial_reports',
                    'reporting.view_booking_forecasts',
                ],
            ],
            [
                'group_name' => 'role',
                'permissions' => [  // Admin
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ],
            ],
            [
                'group_name' => 'profile',
                'permissions' => [  // All users
                    'profile.view',
                    'profile.edit',
                    'profile.delete',
                    'profile.update',
                ],
            ],
            [
                'group_name' => 'monitoring',
                'permissions' => [  // Admin
                    'pulse.view',
                    'actionlog.view',
                ],
            ],
            [
                'group_name' => 'settings',
                'permissions' => [  // Admin
                    'settings.view',
                    'settings.edit',
                ],
            ],
            [
                'group_name' => 'translations',
                'permissions' => [  // Admin
                    'translations.view',
                    'translations.edit',
                ],
            ],
        ];

        return $permissions;
    }

    /**
     * Get a specific set of permissions by group name
     *
     * @param string $groupName
     * @return array|null
     */
    public function getPermissionsByGroup(string $groupName): ?array
    {
        $permissions = $this->getAllPermissions();

        foreach ($permissions as $permissionGroup) {
            if ($permissionGroup['group_name'] === $groupName) {
                return $permissionGroup['permissions'];
            }
        }

        return null;
    }

    /**
     * Get all permission group names
     *
     * @return array
     */
    public function getPermissionGroups(): array
    {
        $groups = [];
        foreach ($this->getAllPermissions() as $permission) {
            $groups[] = $permission['group_name'];
        }

        return $groups;
    }

    /**
     * Get all permission models from database
     *
     * @return Collection
     */
    public function getAllPermissionModels(): Collection
    {
        return Permission::all();
    }

    /**
     * Get permissions by group name from database
     *
     * @param string $group_name
     * @return Collection
     */
    public function getPermissionModelsByGroup(string $group_name): Collection
    {
        return Permission::select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
    }

    /**
     * Get permission groups from database
     *
     * @return Collection
     */
    public function getDatabasePermissionGroups(): Collection
    {
        return Permission::select('group_name as name')
            ->groupBy('group_name')
            ->get();
    }

    /**
     * Create all permissions from the definitions
     *
     * @return array Created permissions
     */
    public function createPermissions(): array
    {
        $createdPermissions = [];
        $permissions = $this->getAllPermissions();

        foreach ($permissions as $permissionGroup) {
            $groupName = $permissionGroup['group_name'];

            foreach ($permissionGroup['permissions'] as $permissionName) {
                $permission = $this->findOrCreatePermission($permissionName, $groupName);
                $createdPermissions[] = $permission;
            }
        }

        return $createdPermissions;
    }

    /**
     * Find or create a permission
     *
     * @param string $name
     * @param string $groupName
     * @return Permission
     */
    public function findOrCreatePermission(string $name, string $groupName): Permission
    {
        return Permission::firstOrCreate(
            ['name' => $name],
            [
                'name' => $name,
                'group_name' => $groupName,
                'guard_name' => 'web',
            ]
        );
    }

    /**
     * Get all permission objects by their names
     *
     * @param array $permissionNames
     * @return array
     */
    public function getPermissionsByNames(array $permissionNames): array
    {
        return Permission::whereIn('name', $permissionNames)->get()->all();
    }

    /**
     * Get paginated permissions with role count
     *
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedPermissionsWithRoleCount(string $search = null, ?int $perPage): LengthAwarePaginator
    {
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('group_name', 'like', '%' . $search . '%');
        }

        $permissions = $query->paginate($perPage ?? config('settings.default_pagination'));

        // Add role count and roles information to each permission.
        foreach ($permissions as $permission) {
            $roles = $permission->roles()->get();
            $permission->role_count = $roles->count();
            $permission->roles_list = $roles->pluck('name')->take(5)->implode(', ');

            if ($permission->role_count > 5) {
                $permission->roles_list .= ', ...';
            }
        }

        return $permissions;
    }

    /**
     * Get roles for permission
     *
     * @param Permission $permission
     * @return Collection
     */
    public function getRolesForPermission(Permission $permission): Collection
    {
        return $permission->roles()->get();
    }
}
