<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesService
{
    public function __construct(private readonly PermissionService $permissionService)
    {
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRolesDropdown(): array
    {
        return Role::pluck('name', 'id')->toArray();
    }

    public function getPaginatedRoles(string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Role::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public static function getPermissionsByGroupName(string $group_name): Collection
    {
        return Permission::select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
    }

    /**
     * Get permissions by group
     * 
     * @param string $groupName
     * @return array|null
     */
    public function getPermissionsByGroup(string $groupName): ?array
    {
        return $this->permissionService->getPermissionsByGroup($groupName);
    }

    public function roleHasPermissions(Role $role, $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                return false;
            }
        }

        return true;
    }

    public function createRole(string $name, array $permissions = []): Role
    {
        $role = Role::create(['name' => $name, 'guard_name' => 'web']);

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function findRoleById(int $id): ?Role
    {
        return Role::findById($id);
    }

    public function updateRole(Role $role, string $name, array $permissions = []): Role
    {
        $role->name = $name;
        $role->save();

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        return $role->delete();
    }

    /**
     * Count users in a specific role
     * 
     * @param Role|string $role
     * @return int
     */
    public function countUsersInRole($role): int
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
            if (!$role) {
                return 0;
            }
        }

        return $role->users->count();
    }

    /**
     * Get roles with user counts
     * 
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedRolesWithUserCount(string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Role::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $roles = $query->paginate($perPage);

        // Add user count to each role
        foreach ($roles as $role) {
            $role->user_count = $this->countUsersInRole($role);
        }

        return $roles;
    }

    /**
     * Create predefined roles with their permissions
     * 
     * @return array
     */
    public function createPredefinedRoles(): array
    {
        $roles = [];

        // 1. Superadmin role - has all permissions
        $allPermissionNames = [];
        foreach ($this->permissionService->getAllPermissions() as $group) {
            foreach ($group['permissions'] as $permission) {
                $allPermissionNames[] = $permission;
            }
        }

        $roles['superadmin'] = $this->createRole('Superadmin', $allPermissionNames);

        // 2. Admin role - has almost all permissions except some critical ones
        $adminPermissions = $allPermissionNames;
        $adminExcludedPermissions = [
            'user.delete', // Cannot delete users
        ];

        $adminPermissions = array_diff($adminPermissions, $adminExcludedPermissions);
        $roles['admin'] = $this->createRole('Admin', $adminPermissions);

        // 3. Editor role - can manage content but not users/settings
        $editorPermissions = [
            'dashboard.view',
            // Blog permissions
            'blog.create',
            'blog.view',
            'blog.edit',
            // Profile permissions
            'profile.view',
            'profile.edit',
            'profile.update',
            // Translations
            'translations.view',
        ];

        $roles['editor'] = $this->createRole('Editor', $editorPermissions);

        // 4. Subscriber role - basic user role
        $subscriberPermissions = [
            'dashboard.view',
            'profile.view',
            'profile.edit',
            'profile.update',
        ];

        $roles['subscriber'] = $this->createRole('Subscriber', $subscriberPermissions);

        return $roles;
    }

    /**
     * Get a specific predefined role's permissions
     * 
     * @param string $roleName
     * @return array
     */
    public function getPredefinedRolePermissions(string $roleName): array
    {
        $roleName = strtolower($roleName);

        switch ($roleName) {
            case 'superadmin':
                // All permissions
                $allPermissionNames = [];
                foreach ($this->permissionService->getAllPermissions() as $group) {
                    foreach ($group['permissions'] as $permission) {
                        $allPermissionNames[] = $permission;
                    }
                }
                return $allPermissionNames;

            case 'admin':
                // All except some critical permissions
                $adminExcludedPermissions = [
                    'user.delete',
                ];
                $allPermissionNames = [];
                foreach ($this->permissionService->getAllPermissions() as $group) {
                    foreach ($group['permissions'] as $permission) {
                        $allPermissionNames[] = $permission;
                    }
                }
                return array_diff($allPermissionNames, $adminExcludedPermissions);

            case 'editor':
                return [
                    'dashboard.view',
                    'blog.create',
                    'blog.view',
                    'blog.edit',
                    'profile.view',
                    'profile.edit',
                    'profile.update',
                    'translations.view',
                ];

            case 'subscriber':
            default:
                return [
                    'dashboard.view',
                    'profile.view',
                    'profile.edit',
                    'profile.update',
                ];
        }
    }
}
