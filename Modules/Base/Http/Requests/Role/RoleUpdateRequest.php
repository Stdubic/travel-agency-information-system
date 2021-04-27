<?php

namespace Modules\Base\Http\Requests\Role;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class RoleUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-role')) {
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
            'name' => 'required|string',
            'group_id' => 'required|exists:role_groups,id',
            'type' => 'required|in:user,manager',
            'groups' => 'array',
            'groups.*' => 'integer|exists:permission_groups,id',
            'permission' => 'required|array'
        ];
    }
}
