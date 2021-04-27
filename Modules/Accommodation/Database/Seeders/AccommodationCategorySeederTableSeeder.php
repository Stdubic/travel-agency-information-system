<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Entities\AccommodationCategory;

class AccommodationCategorySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        AccommodationCategory::create([
            'hr' => [
                'title' => 'Obitelj'
            ],
            'en' => [
                'title' => 'Family'
            ],
            'de' => [
                'title' => 'Family'
            ],
            'ru' => [
                'title' => 'Family'
            ]
        ]);

        AccommodationCategory::create([
            'hr' => [
                'title' => 'Wellness'
            ],
            'en' => [
                'title' => 'Wellness'
            ],
            'de' => [
                'title' => 'Wellness'
            ],
            'ru' => [
                'title' => 'Wellness'
            ]
        ]);

        // $this->call("OthersTableSeeder");
    }
}
