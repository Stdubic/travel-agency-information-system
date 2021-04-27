<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Entities\AccommodationType;

class AccommodationTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        AccommodationType::create([
            'hr' => [
                'title' => 'Single Room HR'
            ],
            'en' => [
                'title' => 'Single Room EN'
            ],
            'de' => [
                'title' => 'Single Room DE'
            ],
            'ru' => [
                'title' => 'Single Room RU'
            ],
            'standard_capacity' => 2,
            'max_capacity' => 2,
            'min_capacity' => 2,
            'max_adults' => 2,
            'min_children' => 1,
            'description' => 1,
        ]);

        AccommodationType::create([
            'hr' => [
                'title' => 'Triple room'
            ],
            'en' => [
                'title' => 'Triple room'
            ],
            'de' => [
                'title' => 'Triple room'
            ],
            'ru' => [
                'title' => 'Triple room'
            ],
            'standard_capacity' => 3,
            'max_capacity' => 3,
            'min_capacity' => 3,
            'max_adults' => 1,
            'min_children' => 2,
            'description' => 1,
        ]);

        // $this->call("OthersTableSeeder");
    }
}
