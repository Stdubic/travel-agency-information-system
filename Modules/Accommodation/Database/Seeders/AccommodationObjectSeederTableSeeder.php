<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Entities\AccommodationObject;

class AccommodationObjectSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(AccommodationObject $object)
    {
        Model::unguard();

        $object = $object->create([
            'name' => 'Testni hotel',
            'type' => 'hotel',
            'country_id' => 52,
            'region_id' => 1,
            'city_id' => 1,
            'supplier_id' => 1,
            'tel_num' => '098/111-222',
            'rating' => '5',
            'channel_manager' => 'phobs',
            'channel_manager_code' => 'ATL476',
            'long' => '16.2460249',
            'lat' => '43.6599217',
            'reception_email' => 'test@mail.com',
            'booking_email' => 'booking@mail.com',
            'office_phone' => '+123456',
            'website' => 'www.site.com',
            'address' => 'Adresa 10',
            'time_zone' => '-5',
            'currency' => 'hrk',
            'bank_name' => 'bank',
            'bank_office' => 'ured 1',
            'bank_swift' => 'HRXXX',
            'account_number' => '5454gfg',
            'company_name' => 'company1',
            'bank_iban' => 'HR45454f54g45',
            'contact_person' => 'Ivo Ivic',
            'added_tax' => '2',
            'office_tax' => '4',
            'is_synced' => 0,
        ]);

        $object->settings()->create([
            'sojourn_tax' => 1,
            'front_visibility' => 1,
            'admin_visibility' => 1,
            'recommendation' => 0,
            'rating' => 0,
            'medical' => 0,
            'household' => 0,
        ]);
        // $this->call("OthersTableSeeder");
    }
}
