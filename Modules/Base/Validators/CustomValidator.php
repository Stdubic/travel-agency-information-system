<?php

namespace Modules\Base\Validators;

use Modules\Base\Entities\Role;
use Modules\Base\Entities\User;
use Illuminate\Support\Facades\DB;


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
    public function superadmin($message, $attribute, $rule, $parameters)
    {
        $user = User::find($rule[0]);

        if(!$user) {
            return false;
        }

        $role = $user->roles->first();

        if(!$role) {
            return true;
        }

        if($role->name === 'Superadmin' && $role->id != $attribute) {
            $count = DB::table('model_has_roles')->where('role_id', 1)->count();

            if($count === 1) {
                return false;
            }
        }

        return true;
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
    public function superadminReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "There must be at least one Superadmin in system";

        return $message;
    }
}
