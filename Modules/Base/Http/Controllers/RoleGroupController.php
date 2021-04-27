<?php

namespace Modules\Base\Http\Controllers;

use Modules\Base\Entities\RoleGroup;
use Modules\Base\Http\Requests\RoleGroup\RoleGroupCreateRequest;
use Modules\Base\Http\Requests\RoleGroup\RoleGroupDeleteRequest;
use Modules\Base\Http\Requests\RoleGroup\RoleGroupEditRequest;
use Modules\Base\Http\Requests\RoleGroup\RoleGroupListRequest;
use Modules\Base\Http\Requests\RoleGroup\RoleGroupStoreRequest;
use Modules\Base\Http\Requests\RoleGroup\RoleGroupUpdateRequest;

class RoleGroupController extends Controller
{

    /**
     * Lists role group entity
     *
     * @param RoleGroupListRequest $request
     * @param RoleGroup $roleGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(RoleGroupListRequest $request, RoleGroup $roleGroup)
    {
        $groups = $roleGroup->paginate(50);

        return view('base::role.group.list', compact('groups'));
    }

    /**
     * Returns form for creating role group
     *
     * @param RoleGroupCreateRequest $request
     * @param RoleGroup $roleGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleGroupCreateRequest $request, RoleGroup $roleGroup)
    {
        return view('base::role.group.create', compact('roleGroup'));
    }

    /**
     * Creates role group entity
     *
     * @param RoleGroupStoreRequest $request
     * @param RoleGroup $roleGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleGroupStoreRequest $request,  RoleGroup $roleGroup)
    {
        try {
            $roleGroup->create([
                'name' => $request->input('name'),
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.role.group.store.error'));
        }

        return redirect()->back()->with('success', __('base::base.role.group.store.success'));
    }

    /**
     * Edit role group entity
     *
     * @param RoleGroupEditRequest $request
     * @param RoleGroup $roleGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RoleGroupEditRequest $request, RoleGroup $roleGroup)
    {
        return view('base::role.group.create', compact('roleGroup'));
    }

    /**
     * Update role group entity
     *
     * @param RoleGroupUpdateRequest $request
     * @param RoleGroup $roleGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleGroupUpdateRequest $request, RoleGroup $roleGroup)
    {
        try {
            $roleGroup->update([
                'name' => $request->input('name'),
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.role.group.update.error'));
        }

        return redirect()->back()->with('success', __('base::base.role.group.update.success'));
    }


    /**
     * Deletes role group entity
     *
     * @param RoleGroupDeleteRequest $request
     * @param RoleGroup $roleGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RoleGroupDeleteRequest $request, RoleGroup $roleGroup)
    {
        $group = $roleGroup->find($request->route('id'));

        try {
            $group->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.role.group.delete.error'));
        }

        return redirect()->back()->with('success', __('base::base.role.group.delete.success'));
    }
}
