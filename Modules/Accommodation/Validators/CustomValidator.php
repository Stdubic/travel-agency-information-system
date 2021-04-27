<?php

namespace Modules\Accommodation\Validators;

use Modules\Accommodation\Entities\AccommodationObject;

class CustomValidator
{
    /**
     * Check if there is category for that inventory category
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function inObject($message, $attribute, $rule, $parameters)
    {
        /** @var AccommodationObject $accommodationObject */
        $accommodationObject =  AccommodationObject::find($rule[0]);

        if(!$accommodationObject) {
            return false;
        }

        $accommodationUnit = $accommodationObject->units()->find($attribute);

        if($accommodationUnit) {
            return true;
        }

        return false;
    }

    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function inObjectReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Accommodation object does not have that unit.";

        return $message;
    }


    /**
     * Check if there is category for that inventory category
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function forPlan($message, $attribute, $rule, $parameters)
    {
        /** @var AccommodationObject $accommodationObject */
        $accommodationObject =  AccommodationObject::find($rule[1]);

        if(!$accommodationObject) {
            return false;
        }

        $accommodationUnit = $accommodationObject->units()->find($rule[0]);

        if($accommodationUnit) {
            $ratePlan = $accommodationUnit->rates()->find($attribute);

            if($ratePlan) {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function forPlanReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Plan does not exists in that unit/object combination.";

        return $message;
    }
}
