<?php

namespace Modules\Accommodation\Http\Requests\AccommodationUnit;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AccommodationUnitStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('create-accommodation-unit')) {
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
            'accommodation_object' => 'required|int|exists:accommodation_objects,id',
            'name' => 'required|string',
            'unit_type' => 'required|int|exists:accommodation_unit_types,id',
            'basic_bed_num' => 'required|int',
            'additional_bed_num' => 'required|int',
            'position' => 'required|string|in:nd,ss,ps,hs',
            'view' => 'required|string|in:sea,sea-side,lake,river,mountain,park,forest,center,quite,busy,garden,backyard,golf,pool',
            'qty' => 'required|int',
            'rating' => 'required|int|in:1,2,3,4,5',
            'active' => 'boolean',
            'sojourn_tax' => 'boolean',
        ];
    }
}
