<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccommodationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CountrySeederTableSeeder::class);
        $this->call(AccommodationCategorySeederTableSeeder::class);
        $this->call(AccommodationTypeSeederTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(AccommodationObjectSeederTableSeeder::class);
        $this->call(AmenitiesSeederTableSeeder::class);
        //$this->call(AccommodationPermissionSeederTableSeeder::class);
    }
}
