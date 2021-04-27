<?php

namespace Modules\Accommodation\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Base\Entities\User;
use Modules\Accommodation\Entities\AccommodationObject;

class AccommodationObjectPolicy
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
     * Determine whether the user can update the accommodation object.
     *
     * @param User $user
     * @param AccommodationObject $accommodationObject
     * @return bool
     */
    public function update(User $user, AccommodationObject $accommodationObject)
    {
        return $user->id === $accommodationObject->supplier_id;
    }

    /**
     * Determine whether the user can update the accommodation object.
     *
     * @param User $user
     * @param AccommodationObject $accommodationObject
     * @return bool
     */
    public function delete(User $user, AccommodationObject $accommodationObject)
    {
        return $user->id === $accommodationObject->supplier_id;
    }
}
