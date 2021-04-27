<?php

namespace Modules\Base\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Base\Entities\User;
use Modules\Base\Http\Controllers\Controller;

class UsersController extends Controller
{

    /**
     * Return value for user autocomplete
     *
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function autocomplete(Request $request, User $user)
    {
        $term = $request->input('term');

        $users = $user->where('name', $term)->orWhere('name', 'like', '%' . $term . '%')->get();

        foreach ($users as $user) {
            $results[] = ['email' => $user->email, 'value' => $user->name];
        }

        return $results;
    }
}
