<?php

namespace Modules\Base\Http\Controllers;

use Modules\Accommodation\Entities\Country;
use Modules\Base\Entities\LegalUser;
use Modules\Base\Entities\NaturalUser;
use Modules\Base\Entities\Role;
use Modules\Base\Entities\RoleGroup;
use Modules\Base\Entities\User;
use Modules\Base\Http\Requests\User\UserCreateRequest;
use Modules\Base\Http\Requests\User\UserDeleteRequest;
use Modules\Base\Http\Requests\User\UserEditRequest;
use Modules\Base\Http\Requests\User\UserGetAssignRoleRequest;
use Modules\Base\Http\Requests\User\UserListRequest;
use Modules\Base\Http\Requests\User\UserPostAssignRoleRequest;
use Modules\Base\Http\Requests\User\UserStoreRequest;
use Modules\Base\Http\Requests\User\UserUpdateRequest;


class UserController extends Controller
{
    /**
     * Lists user entity
     *
     * @param UserListRequest $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(UserListRequest $request, User $user)
    {
        $users = $user->with(['userable', 'country'])->paginate(50);

        return view('base::user.list', compact('users'));
    }

    /**
     * Returns form for creating users
     *
     * @param UserCreateRequest $request
     * @param User $user
     * @param Country $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(UserCreateRequest $request, User $user, Country $country)
    {
        $countries = array_merge([0 => 'Choose'], $country->pluck('name', 'id')->toArray());

        return view('base::user.create', compact(['user', 'countries']));
    }

    /**
     * Stores user entity and subentity
     *
     * @param UserStoreRequest $request
     * @param User $user
     * @param LegalUser $legalUser
     * @param NaturalUser $naturalUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request, User $user, LegalUser $legalUser, NaturalUser $naturalUser)
    {
        try {
            $user = $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'oib' => $request->input('oib'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                'country_id' => $request->input('country_id'),
                'tel_num' => $request->input('tel_num'),
                'mobile_num' => $request->input('mobile_num'),
                'fax' => $request->input('fax'),
                'skype' => $request->input('skype'),
                'bank_name' => $request->input('bank_name'),
                'iban' => $request->input('iban'),
                'swift' => $request->input('swift'),
                'affiliate_num' => $request->input('affiliate_num'),
                'description' => $request->input('description')
            ]);

            if ($request->input('type') === 'legal') {
                $additionalUser = $legalUser->create([
                    'legal_id' => $request->input('legal_id')
                ]);
            } else {
                $additionalUser = $naturalUser->create([
                    'first_name' => $request->input('first_name'),
                    'middle_name' => $request->input('middle_name'),
                    'last_name' => $request->input('last_name'),
                    'id_num' => $request->input('id_num'),
                    'birth_date' => $request->input('birth_date'),
                    'passport_num' => $request->input('passport_num'),
                    'passport_issued_at' => $request->input('passport_issued_at'),
                    'passport_expired_at' => $request->input('passport_expired_at'),
                    'nationality' => $request->input('nationality'),
                    'sex' => $request->input('sex'),
                    'website' => $request->input('website'),
                ]);
            }

            $additionalUser->user()->save($user);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.user.store.error'));
        }

        return redirect()->back()->with('success', __('base::base.user.store.success'));
    }

    /**
     * Returns form for editing user entity
     *
     * @param UserEditRequest $request
     * @param User $user
     * @param Country $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UserEditRequest $request, User $user, Country $country)
    {
        $countries = array_merge([0 => 'Choose'], $country->pluck('name', 'id')->toArray());

        return view('base::user.create', compact(['user', 'countries']));
    }

    /**
     * Updates user entity
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->load('userable');

        $additionalUser = $user->userable;

        try {
            $user->update([
                'name' => $request->input('name'),
                'password' => $request->input('password'),
                'oib' => $request->input('oib'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                'country_id' => $request->input('country_id'),
                'tel_num' => $request->input('tel_num'),
                'mobile_num' => $request->input('mobile_num'),
                'fax' => $request->input('fax'),
                'skype' => $request->input('skype'),
                'bank_name' => $request->input('bank_name'),
                'iban' => $request->input('iban'),
                'swift' => $request->input('swift'),
                'affiliate_num' => $request->input('affiliate_num'),
                'description' => $request->input('description')
            ]);

            if ($request->input('type') === 'legal') {
                $additionalUser->update([
                    'legal_id' => $request->input('legal_id')
                ]);
            } else {
                $additionalUser->update([
                    'first_name' => $request->input('first_name'),
                    'middle_name' => $request->input('middle_name'),
                    'last_name' => $request->input('last_name'),
                    'id_num' => $request->input('id_num'),
                    'birth_date' => $request->input('birth_date'),
                    'passport_num' => $request->input('passport_num'),
                    'passport_issued_at' => $request->input('passport_issued_at'),
                    'passport_expired_at' => $request->input('passport_expired_at'),
                    'nationality' => $request->input('nationality'),
                    'sex' => $request->input('sex'),
                    'website' => $request->input('website'),
                ]);
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.user.update.error'));
        }

        return redirect()->back()->with('success', __('base::base.user.update.success'));
    }

    /**
     * Deletes user entity
     *
     * @param UserDeleteRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserDeleteRequest $request, User $user)
    {
        $user = $user->find($request->route('id'));
        try {
            $user->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.user.delete.error'));
        }

        return redirect()->back()->with('success', __('base::base.user.delete.success'));
    }

    /**
     * Returns user list with roles
     *
     * @param UserGetAssignRoleRequest $request
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAssignRole(UserGetAssignRoleRequest $request, User $user, RoleGroup $roleGroup)
    {
        $users = $user->with(['roles'])->paginate(50);

        $roleGroups = $roleGroup->with('roles')->get();

        return view('base::role.assign.list', compact(['users', 'roleGroups']));
    }

    /**
     * Assign role to user
     *
     * @param UserPostAssignRoleRequest $request
     * @param User $user
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAssignRole(UserPostAssignRoleRequest $request, User $user, Role $role)
    {
        try {
            $user = $user->findOrFail($request->route('id'));
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'User not found.'
            ])->setStatusCode(404);
        }

        $role = $role->find($request->input('role'));

        $user->syncRoles($role);

        return response()->json([
            'message' => 'Role set successfully.'
        ])->setStatusCode(200);
    }
}
