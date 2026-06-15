<?php

namespace Tests\Feature\Database;

use Database\Seeders\Data\RolesAndPermissionsDefinition;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_default_permissions_and_roles(): void
    {
        $this->seed(RoleSeeder::class);

        $this->assertDatabaseCount('permissions', count(RolesAndPermissionsDefinition::permissions()));
        $this->assertDatabaseCount('roles', count(RolesAndPermissionsDefinition::roles()));

        $superAdmin = Role::findByName('super-admin', RolesAndPermissionsDefinition::GUARD);

        $this->assertTrue($superAdmin->hasPermissionTo('panel.access'));
        $this->assertTrue($superAdmin->hasPermissionTo('users.delete'));
        $this->assertTrue($superAdmin->hasPermissionTo('permissions.delete'));
    }

    public function test_can_be_run_repeatedly_without_duplicates(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(RoleSeeder::class);

        $this->assertDatabaseCount('permissions', count(RolesAndPermissionsDefinition::permissions()));
        $this->assertDatabaseCount('roles', count(RolesAndPermissionsDefinition::roles()));
    }

    public function test_does_not_remove_custom_permissions_or_role_assignments(): void
    {
        $this->seed(RoleSeeder::class);

        $customPermission = Permission::create([
            'name' => 'reports.export',
            'guard_name' => RolesAndPermissionsDefinition::GUARD,
        ]);

        $admin = Role::findByName('admin', RolesAndPermissionsDefinition::GUARD);
        $admin->givePermissionTo($customPermission);

        $this->seed(RoleSeeder::class);

        $this->assertDatabaseHas('permissions', ['name' => 'reports.export']);
        $this->assertTrue($admin->fresh()->hasPermissionTo('reports.export'));
    }

    public function test_assigns_limited_permissions_to_viewer_role(): void
    {
        $this->seed(RoleSeeder::class);

        $viewer = Role::findByName('viewer', RolesAndPermissionsDefinition::GUARD);

        $this->assertTrue($viewer->hasPermissionTo('users.view'));
        $this->assertFalse($viewer->hasPermissionTo('users.create'));
        $this->assertFalse($viewer->hasPermissionTo('roles.create'));
    }
}
