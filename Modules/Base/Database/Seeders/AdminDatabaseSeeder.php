<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Seeder;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\Base\Entities\User::create([
            'name' => 'ante',
            'email' => 'ante@admin.com',
            'password' => 'pass'
        ]);

        \Modules\Base\Entities\User::create([
            'name' => 'antimon',
            'email' => 'antimon@admin.com',
            'password' => 'pass'
        ]);

        \Modules\Base\Entities\User::create([
            'name' => 'aleksa',
            'email' => 'aleksa@admin.com',
            'password' => 'pass'
        ]);
    }
}
