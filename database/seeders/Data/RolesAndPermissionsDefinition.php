<?php

namespace Database\Seeders\Data;

/**
 * Fuente única de permisos y roles predeterminados.
 *
 * Al agregar permisos o asignaciones aquí, ejecuta:
 * php artisan db:seed --class=RoleSeeder
 *
 * La sincronización es incremental: crea lo que falta y asigna permisos nuevos
 * sin eliminar roles, permisos ni asignaciones personalizadas en la base de datos.
 */
class RolesAndPermissionsDefinition
{
    public const GUARD = 'web';

    /**
     * @return list<string>
     */
    public static function permissions(): array
    {
        return [
            'panel.access',
            'dashboard.view',

            'users.viewAny',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            'roles.viewAny',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            'permissions.viewAny',
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
        ];
    }

    /**
     * Roles predeterminados y sus permisos.
     *
     * Usa '*' para conceder todos los permisos definidos en permissions().
     *
     * @return array<string, list<string>|'*'>
     */
    public static function roles(): array
    {
        return [
            'super-admin' => '*',
            'admin' => [
                'panel.access',
                'dashboard.view',
                'users.viewAny',
                'users.view',
                'users.create',
                'users.update',
                'users.delete',
                'roles.viewAny',
                'roles.view',
            ],
            'manager' => [
                'panel.access',
                'dashboard.view',
                'users.viewAny',
                'users.view',
                'users.create',
                'users.update',
            ],
            'viewer' => [
                'panel.access',
                'dashboard.view',
                'users.viewAny',
                'users.view',
                'roles.viewAny',
                'roles.view',
            ],
        ];
    }
}
