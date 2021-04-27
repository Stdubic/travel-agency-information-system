<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Base\Entities\Permission;
use Modules\Base\Entities\PermissionGroup;

class AccommodationPermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Reset cached roles and permissions

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Accommodation group

        $accommodationGroup = PermissionGroup::create(['name' => 'Accommodation']);

        //Acc object dashboard

        Permission::create(['name' => 'view-accommodation-object', 'display_name' => 'View accommodation object navigation', 'group_id' => $accommodationGroup->id]);

        //Acc object type
        Permission::create(['name' => 'create-accommodation-object-type', 'display_name' => 'Create accommodation object type', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-accommodation-object-type', 'display_name' => 'Update accommodation object type', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-accommodation-object-type', 'display_name' => 'Delete accommodation object type', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-accommodation-object-type', 'display_name' => 'List accommodation object types', 'group_id' => $accommodationGroup->id]);

        //Acc object category

        Permission::create(['name' => 'create-accommodation-object-category', 'display_name' => 'Create accommodation object category', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-accommodation-object-category', 'display_name' => 'Update accommodation object category', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-accommodation-object-category', 'display_name' => 'Delete accommodation object category', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-accommodation-object-category', 'display_name' => 'List accommodation object categories', 'group_id' => $accommodationGroup->id]);

        //Acc object

        Permission::create(['name' => 'create-accommodation-object', 'display_name' => 'Create accommodation object', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-accommodation-object', 'display_name' => 'Update accommodation object', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-accommodation-object', 'display_name' => 'Delete accommodation object', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-accommodation-object', 'display_name' => 'List accommodation objects', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'sync-accommodation-object', 'display_name' => 'Sync accommodation objects', 'group_id' => $accommodationGroup->id]);

        //Acc unit dashboard

        Permission::create(['name' => 'view-accommodation-unit', 'display_name' => 'View accommodation unit navigation', 'group_id' => $accommodationGroup->id]);

        //Acc unit type

        Permission::create(['name' => 'create-accommodation-unit-type', 'display_name' => 'Create accommodation unit type', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-accommodation-unit-type', 'display_name' => 'Update accommodation unit type', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-accommodation-unit-type', 'display_name' => 'Delete accommodation unit type', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-accommodation-unit-type', 'display_name' => 'List accommodation unit types', 'group_id' => $accommodationGroup->id]);

        //Acc unit

        Permission::create(['name' => 'create-accommodation-unit', 'display_name' => 'Create accommodation unit', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-accommodation-unit', 'display_name' => 'Update accommodation unit', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-accommodation-unit', 'display_name' => 'Delete accommodation unit', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-accommodation-unit', 'display_name' => 'List accommodation units', 'group_id' => $accommodationGroup->id]);

        //Amenities dashboard

        Permission::create(['name' => 'view-amenity', 'display_name' => 'View amenity navigation', 'group_id' => $accommodationGroup->id]);

        //Amenity set

        Permission::create(['name' => 'create-amenity-set', 'display_name' => 'Create amenity set', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-amenity-set', 'display_name' => 'Update amenity set', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-amenity-set', 'display_name' => 'Delete amenity set', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-amenity-set', 'display_name' => 'List amenity sets', 'group_id' => $accommodationGroup->id]);

        //Amenity

        Permission::create(['name' => 'create-amenity', 'display_name' => 'Create amenity', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'update-amenity', 'display_name' => 'Update amenity', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'delete-amenity', 'display_name' => 'Delete amenity', 'group_id' => $accommodationGroup->id]);
        Permission::create(['name' => 'list-amenity', 'display_name' => 'List amenities', 'group_id' => $accommodationGroup->id]);

        // Rate plans group

        $ratePlansGroup = PermissionGroup::create(['name' => 'Rate plans']);

        //Rate plan dashboard

        Permission::create(['name' => 'view-rate-plan', 'display_name' => 'View rate plan navigation', 'group_id' => $ratePlansGroup->id]);

        //Rate plan

        Permission::create(['name' => 'create-rate-plan', 'display_name' => 'Create rate plan', 'group_id' => $ratePlansGroup->id]);
        Permission::create(['name' => 'update-rate-plan', 'display_name' => 'Update rate plan', 'group_id' => $ratePlansGroup->id]);
        Permission::create(['name' => 'delete-rate-plan', 'display_name' => 'Delete rate plan', 'group_id' => $ratePlansGroup->id]);
        Permission::create(['name' => 'list-rate-plan', 'display_name' => 'List rate plans', 'group_id' => $ratePlansGroup->id]);

    }
}
