<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

trait SyncsRolesAndPermissions
{
    /**
     * @param  list<string>  $permissionNames
     * @return Collection<int, Permission>
     */
    protected function syncPermissions(array $permissionNames, string $guard): Collection
    {
        return collect($permissionNames)->map(
            fn (string $name): Permission => Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard,
            ]),
        );
    }

    /**
     * @param  array<string, list<string>|'*'>  $roleDefinitions
     */
    protected function syncRoles(array $roleDefinitions, Collection $permissions, string $guard): void
    {
        foreach ($roleDefinitions as $roleName => $permissionNames) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guard,
            ]);

            $permissionsToAssign = $permissionNames === '*'
              ? $permissions
              : $permissions->whereIn('name', $permissionNames);

            foreach ($permissionsToAssign as $permission) {
                if (! $role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                }
            }
        }
    }

    protected function forgetPermissionCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
