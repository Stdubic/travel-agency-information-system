<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Entities\Country;
use Modules\Accommodation\Entities\Region;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Country $country, Region $region)
    {
        Model::unguard();

        $croatia = $country->find(86);

        $croatia->regions()->create([
            'name' => 'Slavonija'
        ]);

        $slavonija = $region->find(1);

        $slavonija->cities()->create([
            'name' => 'Osijek'
        ]);

        // $this->call("OthersTableSeeder");
    }
}
