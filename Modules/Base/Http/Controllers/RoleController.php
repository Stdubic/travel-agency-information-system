<?php

namespace Modules\Base\Http\Controllers;

use Modules\Base\Entities\Permission;
use Modules\Base\Entities\PermissionGroup;
use Modules\Base\Entities\Role;
use Modules\Base\Entities\RoleGroup;
use Modules\Base\Http\Requests\Role\RoleCreateRequest;
use Modules\Base\Http\Requests\Role\RoleDeleteRequest;
use Modules\Base\Http\Requests\Role\RoleEditRequest;
use Modules\Base\Http\Requests\Role\RoleHierarchyRequest;
use Modules\Base\Http\Requests\Role\RoleListRequest;
use Modules\Base\Http\Requests\Role\RoleStoreRequest;
use Modules\Base\Http\Requests\Role\RoleUpdateRequest;

class RoleController extends Controller
{
    /**
     * Returns list of roles
     *
     * @param RoleListRequest $request
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(RoleListRequest $request, Role $role)
    {
        $roles = $role->with('group')->paginate(50);

        return view('base::role.list', compact('roles'));
    }

    /**
     * Returns form for creating role entity
     *
     * @param RoleCreateRequest $request
     * @param Role $role
     * @param RoleGroup $roleGroup
     * @param PermissionGroup $permissionGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleCreateRequest $request, Role $role, RoleGroup $roleGroup, PermissionGroup $permissionGroup)
    {
        $roleGroup = $roleGroup->pluck('name', 'id');

        $permissionGroup = $permissionGroup->with('permissions')->where('name', '!=', 'Base')->get();

        return view('base::role.create', compact(['role', 'roleGroup', 'permissionGroup']));
    }


    /**
     * Creates new role
     *
     * @param RoleStoreRequest $request
     * @param Role $role
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleStoreRequest $request, Role $role, Permission $permission)
    {
        try {
            $role = $role->create([
                'name' => $request->input('name'),
                'group_id' => $request->input('group_id'),
                'type' => $request->input('type')
            ]);

            if(is_array($request->input('groups'))) {
                $role->permissionGroups()->attach(array_keys($request->input('groups')));
            }

            if(is_array($request->input('permission'))) {
                $permissions = array_keys($request->input('permission'));

                if($request->input('type') === 'manager') {
                    $managerPermission = $permission->where('name', 'manager-permission')->firstOrFail();
                    array_push($permissions, $managerPermission->name);
                }

                foreach ($permissions as $permission) {
                    $role->givePermissionTo(
                        $permission
                    );
                }
            }


        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.role.store.error'));
        }

        return redirect()->back()->with('success', __('base::base.role.store.success'));
    }

    /**
     * Returns form for editing role
     *
     * @param RoleEditRequest $request
     * @param Role $role
     * @param RoleGroup $roleGroup
     * @param PermissionGroup $permissionGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RoleEditRequest $request, Role $role, RoleGroup $roleGroup, PermissionGroup $permissionGroup)
    {
        $roleGroup = $roleGroup->pluck('name', 'id');

        $permissionGroup = $permissionGroup->with('permissions')->where('name', '!=', 'Base')->get();

        $permissionGroupArray = $role->permissionGroups->pluck('id')->toArray();

        $permissionArray = [];

        foreach ($role->permissions as $key => $value) {
            $permissionArray[$value->id] = $value->name;
        }

        return view('base::role.create', compact(['role', 'roleGroup', 'permissionGroup', 'permissionGroupArray', 'permissionArray']));
    }

    /**
     * Updates existing role
     *
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleUpdateRequest $request, Role $role, Permission $permission)
    {
        try {
            $role->update([
                'name' => $request->input('name'),
                'group_id' => $request->input('group_id'),
                'type' => $request->input('type')
            ]);

            if(is_array($request->input('groups'))) {
                $role->permissionGroups()->sync(array_keys($request->input('groups')));
            }

            if(is_array($request->input('permission'))) {
                $permissions = array_keys($request->input('permission'));

                if($request->input('type') === 'manager') {
                    $managerPermission = $permission->where('name', 'manager-permission')->firstOrFail();
                    array_push($permissions, $managerPermission->name);
                }

                $role->syncPermissions($permissions);
            }


        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.role.update.error'));
        }

        return redirect()->back()->with('success', __('base::base.role.update.success'));

    }


    /**
     * Deletes role entity
     *
     * @param RoleDeleteRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RoleDeleteRequest $request, Role $role)
    {
        $role = $role->find($request->route('id'));

        try {
            $role->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.role.delete.error'));
        }

        return redirect()->back()->with('success', __('base::base.role.delete.success'));
    }

    /**
     * Returns role hierarchy
     *
     * @param RoleHierarchyRequest $request
     * @param RoleGroup $roleGroup
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleHierarchy(RoleHierarchyRequest $request, RoleGroup $roleGroup, Role $role)
    {
        $groups = $roleGroup->with('roles.permissions')->get();

        return view('base::role.hierarchy', compact(['groups']));
    }
}
