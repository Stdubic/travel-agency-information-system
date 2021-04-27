<?php

namespace Modules\Accommodation\Http\Requests\AccommodationObject;

use Illuminate\Support\Facades\Auth;
use Modules\Base\Http\Requests\BaseRequest;

class AccommodationObjectSyncRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('sync', $this->all()['object'])) || (!$user->can('sync-accommodation-object'))) {
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

        ];
    }
}
