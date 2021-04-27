<?php

namespace Modules\Accommodation\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Base\Entities\User;
use Modules\Accommodation\Entities\AccommodationUnit;

class AccommodationUnitPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user is manager
     *
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->can('manager-permission')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the accommodation unit.
     *
     * @param User $user
     * @param AccommodationUnit $accommodationUnit
     * @return bool
     */
    public function update(User $user, AccommodationUnit $accommodationUnit)
    {
        $unit = $user->units()->find($accommodationUnit->id);

        if($unit) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the accommodation unit.
     *
     * @param User $user
     * @param AccommodationUnit $accommodationUnit
     * @return bool
     */
    public function delete(User $user, AccommodationUnit $accommodationUnit)
    {
        $unit = $user->units()->find($accommodationUnit->id);

        if($unit) {
            return true;
        }

        return false;
    }
}
