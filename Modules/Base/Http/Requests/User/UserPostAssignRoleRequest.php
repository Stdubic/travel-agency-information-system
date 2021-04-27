<?php

namespace Modules\Base\Http\Requests\User;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UserPostAssignRoleRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('assign-role')) {
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
            'role' => 'required|integer|exists:roles,id|superadmin:' . $this->route('id')
        ];
    }
}
