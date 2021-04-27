<?php

namespace Modules\Accommodation\Services;


use Illuminate\Support\Collection;

class PhobsMapper
{



    public function mapRatesUnits(Collection $plans, Collection $units, $response)
    {

        $plans = $plans->keyBy('code');

        $units = $units->keyBy('code');

        $x = 0;
        $i = 0;

        for ($i; $i < count($response['rates_array']); $i++) {

            $planCode = $response['rates_array'][$i]['plan_code'];

            $plan = $plans->get($planCode);

            if(($i + 1) < count($response['rates_array'])) {
                while ((($i + 1) < count($response['rates_array'])) && ($response['rates_array'][$i]['plan_code'] === $response['rates_array'][$i+1]['plan_code'])) { //same plan
                    $i++;
                }
            }

            $unitIds = [];

            for ($x; $x <= $i; $x++) {
                $unitsEntity = $units->get($response['unit_array'][$x]['unit_code']);
                $unitIds[] = $unitsEntity->id;
            }

            $plan->units()->attach($unitIds);

        }
    }
}
