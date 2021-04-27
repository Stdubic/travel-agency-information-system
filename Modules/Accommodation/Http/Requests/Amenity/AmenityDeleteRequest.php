<?php

namespace Modules\Accommodation\Http\Requests\Amenity;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AmenityDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('delete-amenity')) {
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
            'id' => 'required|integer|exists:amenities,id'
        ];
    }
}
