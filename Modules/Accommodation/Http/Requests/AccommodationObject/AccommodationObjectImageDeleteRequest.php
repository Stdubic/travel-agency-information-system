<?php

namespace Modules\Accommodation\Http\Requests\AccommodationObject;

use Modules\Base\Http\Requests\BaseRequest;

class AccommodationObjectImageDeleteRequest extends BaseRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'imageId' => 'required|exists:accommodation_object_images,unique_id'
        ];
    }
}

