<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Database\Seeders\AccommodationPermissionSeederTableSeeder;
use Modules\Base\Entities\PermissionGroup;
use Modules\Base\Entities\Permission;
use Modules\Base\Entities\Role;
use Modules\Base\Entities\RoleGroup;

class BaseRolePermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AccommodationPermissionSeederTableSeeder::class);

        // Base group

        $baseGroup = PermissionGroup::create(['name' => 'Base']);

        // Roles

        Permission::create(['name' => 'view-role', 'display_name' => "View role dashboard", 'group_id' => $baseGroup->id]);

        Permission::create(['name' => 'manager-permission', 'display_name' => "Manage everyone's entities", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'create-role', 'display_name' => "Creates role", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'list-role', 'display_name' => "Lists roles", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'update-role', 'display_name' => "Updates roles", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'delete-role', 'display_name' => "Deletes roles", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'assign-role', 'display_name' => "Assigns roles", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'view-hierarchy-role', 'display_name' => "View role hierarchy", 'group_id' => $baseGroup->id]);

        // Role group

        Permission::create(['name' => 'create-role-group', 'display_name' => "Creates role group", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'list-role-group', 'display_name' => "Lists role group", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'update-role-group', 'display_name' => "Updates role group", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'view-role-group', 'display_name' => "View role group", 'group_id' => $baseGroup->id]);
        Permission::create(['name' => 'delete-role-group', 'display_name' => "Deletes role group", 'group_id' => $baseGroup->id]);

        // General group

        $generalGroup = PermissionGroup::create(['name' => 'General']);

        //Location dashboard

        Permission::create(['name' => 'view-location', 'display_name' => 'View location navigation', 'group_id' => $generalGroup->id]);

        //Region

        Permission::create(['name' => 'create-region', 'display_name' => 'Create region', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'update-region', 'display_name' => 'Update region', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'delete-region', 'display_name' => 'Delete region', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'list-region', 'display_name' => 'List regions', 'group_id' => $generalGroup->id]);

        //City

        Permission::create(['name' => 'create-city', 'display_name' => 'Create city', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'update-city', 'display_name' => 'Update city', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'delete-city', 'display_name' => 'Delete city', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'list-city', 'display_name' => 'List cities', 'group_id' => $generalGroup->id]);

        //User

        //User dashboard

        Permission::create(['name' => 'view-user', 'display_name' => 'View user navigation', 'group_id' => $generalGroup->id]);

        Permission::create(['name' => 'create-user', 'display_name' => 'Create user', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'update-user', 'display_name' => 'Update user', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'delete-user', 'display_name' => 'Delete user', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'list-user', 'display_name' => 'List users', 'group_id' => $generalGroup->id]);

        //Settings

        Permission::create(['name' => 'view-settings', 'display_name' => 'View settings', 'group_id' => $generalGroup->id]);

        //Language

        Permission::create(['name' => 'view-languages', 'display_name' => 'View language', 'group_id' => $generalGroup->id]);

        Permission::create(['name' => 'manage-language', 'display_name' => 'Manage languages', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'create-language', 'display_name' => 'Create new language', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'list-language', 'display_name' => 'List languages', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'update-language', 'display_name' => 'Update language', 'group_id' => $generalGroup->id]);
        Permission::create(['name' => 'delete-language', 'display_name' => 'Delete language', 'group_id' => $generalGroup->id]);

        // Default roles and role groups

        $baseRoleGroup = RoleGroup::create(['name' => 'Base']);

        $admin = Role::create(['name' => 'Superadmin', 'group_id' => $baseRoleGroup->id, 'type' => 'manager']);


        $accommodationRoleGroup = RoleGroup::create(['name' => 'Accommodation']);

        $manager = Role::create(['name' => 'Accommodation manager', 'group_id' => $accommodationRoleGroup->id, 'type' => 'manager']);

        $ratesRoleGroup = RoleGroup::create(['name' => 'Rates']);

        $manager = Role::create(['name' => 'Rates manager', 'group_id' => $ratesRoleGroup->id, 'type' => 'manager']);


        $admin->givePermissionTo(Permission::all());

        $adminUser = \Modules\Base\Entities\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'pass'
        ]);

        $adminUser->assignRole($admin);

    }
}
