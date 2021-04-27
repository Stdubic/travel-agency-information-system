<?php

namespace Modules\Accommodation\Http\Requests;

use Modules\Base\Services\LanguageConfig;
use Modules\Base\Http\Requests\BaseRequest;

class TestRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        foreach (LanguageConfig::get() as $langCode => $langName) {
            $rules["translation.*.{$langCode}.alt"] = ['required', 'string'];
            $rules["translation.*.{$langCode}.description"] = ['required', 'string'];
        }

        $test = array_merge($rules, [
            'files' => 'required|array',
            'files.*' => 'required|image',
            'translation' => 'required|array',
        ]);

        return $test;


    }

}
