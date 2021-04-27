<?php

namespace Modules\Accommodation\Http\Requests\AccommodationObject;

use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AccommodationObjectDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $accommodationObject = AccommodationObject::find($this->all()['id']);

        if((!$user->can('delete', $accommodationObject)) || (!$user->can('delete-accommodation-object'))) {
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
            'id' => 'required|integer|exists:accommodation_objects,id'
        ];
    }
}
