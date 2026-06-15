<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SyncsRolesAndPermissions;
use Database\Seeders\Data\RolesAndPermissionsDefinition;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use SyncsRolesAndPermissions;

    /**
     * Sincroniza permisos y roles predeterminados de forma incremental.
     *
     * Seguro para ejecutar repetidamente: no borra registros ni revoca permisos
     * asignados manualmente. Solo crea lo faltante y asigna permisos nuevos.
     */
    public function run(): void
    {
        $this->forgetPermissionCache();

        $guard = RolesAndPermissionsDefinition::GUARD;

        $permissions = $this->syncPermissions(
            RolesAndPermissionsDefinition::permissions(),
            $guard,
        );

        $this->syncRoles(
            RolesAndPermissionsDefinition::roles(),
            $permissions,
            $guard,
        );

        $this->forgetPermissionCache();

        $this->command?->info(sprintf(
            'Roles y permisos sincronizados (%d permisos, %d roles predeterminados).',
            $permissions->count(),
            count(RolesAndPermissionsDefinition::roles()),
        ));
    }
}
