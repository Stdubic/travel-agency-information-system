<?php

namespace Modules\Base\Http\Requests\User;

use Illuminate\Validation\ValidationException;
use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-user')) {
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
        if($this->input('type') === 'legal') {
            $rules = [
                'type' => 'required|in:legal',
                'name' => 'required|string',
                'legal_id' => 'required|string',
            ];
        } elseif ($this->input('type') === 'private') {
            $rules = [
                'type' => 'required|in:private',
                'first_name' => 'required|string',
                'middle_name' => 'string',
                'last_name' => 'required|string',
                'id_num' => 'numeric',
                'birth_date' => 'required|date|date_format:Y-m-d|before:today',
                'passport_num' => 'numeric',
                'passport_issued_at' => 'date|date_format:Y-m-d|before:today',
                'passport_expired_at' => 'date|date_format:Y-m-d|after:today',
                'nationality' => 'required|string',
                'sex' => 'required|in:m,f',
                'website' => 'string',
            ];
        } else {
            throw ValidationException::withMessages(['Invalid type']);
        }

        $rules = array_merge($rules, [
            'password' => 'required|string',
            'oib' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'country_id' => 'required|integer|exists:countries,id',
            'tel_num' => 'string',
            'mobile_num' => 'string',
            'fax' => 'string',
            'skype' => 'string',
            'bank_name' => 'string',
            'iban' => 'string',
            'affiliate_num' => 'numeric',
            'description' => 'string',
        ]);

        return $rules;
    }
}
