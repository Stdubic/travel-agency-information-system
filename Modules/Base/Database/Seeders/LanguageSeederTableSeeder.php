<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Base\Entities\Language;

class LanguageSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'code' => 'hr',
            'name' => 'Hrvatski',
            'active' => '1',
        ]);

        Language::create([
            'code' => 'en',
            'name' => 'English',
            'active' => '1',
        ]);

        Language::create([
            'code' => 'ru',
            'name' => 'Russian',
            'active' => '1',
        ]);


    }
}
