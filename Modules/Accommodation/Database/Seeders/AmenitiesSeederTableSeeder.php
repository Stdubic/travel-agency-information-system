<?php

namespace Modules\Accommodation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\Amenity;
use Modules\Accommodation\Entities\AmenitySet;
use Rinvex\Attributes\Models\Attribute;

class AmenitiesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $generalSet = AmenitySet::create([
            'hr' => [
                'title' => 'Opčenito',
                'description' => 'Opčenite karakteristike'
            ],
            'en' => [
                'title' => 'General',
                'description' => 'General amenities'
            ],
            'de' => [
                'title' => 'General De',
                'description' => 'Opčenite karakteristike De'
            ],
            'ru' => [
                'title' => 'General Ru',
                'description' => 'Opčenite karakteristike Ru'
            ]
        ]);


        $atm = Amenity::create([
           "hr" => [
                "title" => "Bankomat"
           ],
            "en" => [
                "title" => "Atm en"
            ],
            "de" => [
                "title" => "Atm de"
            ],
            "ru" => [
                "title" => "Atm ru"
            ],
            "amenity_set_id" => $generalSet->id,
            "text_field" => 0,
        ]);

        $freeParking = Amenity::create([
            "hr" => [
                "title" => "Besplatni parking"
            ],
            "en" => [
                "title" => "Free parking en"
            ],
            "de" => [
                "title" => "Free parking de"
            ],
            "ru" => [
                "title" => "Free parking ru"
            ],
            "amenity_set_id" => $generalSet->id,
            "text_field" => 0,
        ]);

        $yearBuilt = Amenity::create([
            "hr" => [
                "title" => "Godina izgradnje"
            ],
            "en" => [
                "title" => "Year built en"
            ],
            "de" => [
                "title" => "Year built de"
            ],
            "ru" => [
                "title" => "Year built ru"
            ],
            "amenity_set_id" => $generalSet->id,
            "text_field" => 1,
        ]);


        $location = AmenitySet::create([
            'hr' => [
                'title' => 'Udaljenost',
                'description' => 'Karakteristike lokacije'
            ],
            'en' => [
                'title' => 'Distance',
                'description' => 'Distance amenities'
            ],
            'de' => [
                'title' => 'Distance De',
                'description' => 'Distance amenities De'
            ],
            'ru' => [
                'title' => 'Distance Ru',
                'description' => 'Distance amenities Ru'
            ]
        ]);

        $distanceCenter = Amenity::create([
            "hr" => [
                "title" => "Udaljenost od centra"
            ],
            "en" => [
                "title" => "Distance from center"
            ],
            "de" => [
                "title" => "Distance from center de"
            ],
            "ru" => [
                "title" => "Distance from center ru"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);


        $distanceBeach = Amenity::create([
            "hr" => [
                "title" => "Udaljenost od plaže"
            ],
            "en" => [
                "title" => "Distance from beach"
            ],
            "de" => [
                "title" => "Distance from beach de"
            ],
            "ru" => [
                "title" => "Distance from beach ru"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceAirport = Amenity::create([
            "hr" => [
                "title" => "Udaljenost od aerodroma"
            ],
            "en" => [
                "title" => "Distance from airport"
            ],
            "de" => [
                "title" => "Distance from airport de"
            ],
            "ru" => [
                "title" => "Distance from airport ru"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceShop = Amenity::create([
            "hr" => [
                "title" => "Trgovina"
            ],
            "en" => [
                "title" => "Shop"
            ],
            "de" => [
                "title" => "Shop de"
            ],
            "ru" => [
                "title" => "Shop ru"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceRovinj = Amenity::create([
            "hr" => [
                "title" => "Rovinj"
            ],
            "en" => [
                "title" => "Rovinj"
            ],
            "de" => [
                "title" => "Rovinj de"
            ],
            "ru" => [
                "title" => "Rovinj ru"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distancePula = Amenity::create([
            "hr" => [
                "title" => "Pula"
            ],
            "en" => [
                "title" => "Pula"
            ],
            "de" => [
                "title" => "Pula"
            ],
            "ru" => [
                "title" => "Pula"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceZagreb = Amenity::create([
            "hr" => [
                "title" => "Zagreb"
            ],
            "en" => [
                "title" => "Zagreb"
            ],
            "de" => [
                "title" => "Zagreb"
            ],
            "ru" => [
                "title" => "Zagreb"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceATM = Amenity::create([
            "hr" => [
                "title" => "Bankomat"
            ],
            "en" => [
                "title" => "ATM"
            ],
            "de" => [
                "title" => "ATM de"
            ],
            "ru" => [
                "title" => "ATM ru"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceWiena = Amenity::create([
            "hr" => [
                "title" => "Wiena"
            ],
            "en" => [
                "title" => "Wiena"
            ],
            "de" => [
                "title" => "Wiena"
            ],
            "ru" => [
                "title" => "Wiena"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);

        $distanceLjubljana = Amenity::create([
            "hr" => [
                "title" => "Ljubljana"
            ],
            "en" => [
                "title" => "Ljubljana"
            ],
            "de" => [
                "title" => "Ljubljana"
            ],
            "ru" => [
                "title" => "Ljubljana"
            ],
            "amenity_set_id" => $location->id,
            "text_field" => 1,
        ]);


        $wellness = AmenitySet::create([
            'hr' => [
                'title' => 'Wellness',
                'description' => 'Karakteristike wellnessa'
            ],
            'en' => [
                'title' => 'Wellness',
                'description' => 'Wellness amenities'
            ],
            'de' => [
                'title' => 'Wellness De',
                'description' => 'Wellness amenities De'
            ],
            'ru' => [
                'title' => 'Wellness Ru',
                'description' => 'Wellness amenities Ru'
            ]
        ]);

        $jacuzzi = Amenity::create([
            "hr" => [
                "title" => "Jacuzzi hr"
            ],
            "en" => [
                "title" => "Jacuzzi en"
            ],
            "de" => [
                "title" => "Jacuzzi de"
            ],
            "ru" => [
                "title" => "Jacuzzi ru"
            ],
            "amenity_set_id" => $wellness->id,
            "text_field" => 0,
        ]);

        $sauna = Amenity::create([
            "hr" => [
                "title" => "Sauna hr"
            ],
            "en" => [
                "title" => "Sauna en"
            ],
            "de" => [
                "title" => "Sauna de"
            ],
            "ru" => [
                "title" => "Sauna ru"
            ],
            "amenity_set_id" => $wellness->id,
            "text_field" => 0,
        ]);

        $massage = Amenity::create([
            "hr" => [
                "title" => "Massage hr"
            ],
            "en" => [
                "title" => "Massage en"
            ],
            "de" => [
                "title" => "Massage de"
            ],
            "ru" => [
                "title" => "Massage ru"
            ],
            "amenity_set_id" => $wellness->id,
            "text_field" => 0,
        ]);
    }
}
