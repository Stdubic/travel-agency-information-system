<?php

namespace Modules\Base\Http\Requests\Role;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class RoleStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('create-role')) {
            return false;
        }

        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'group_id' => 'required|exists:role_groups,id',
            'type' => 'required|in:user,manager',
            'groups' => 'array',
            'groups.*' => 'integer|exists:permission_groups,id',
            'permission' => 'required|array'
        ];
    }
}
