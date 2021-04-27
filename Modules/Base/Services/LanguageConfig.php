<?php

namespace Modules\Base\Services;

use Modules\Base\Entities\Language;

class LanguageConfig
{
    /**
     * Get active languages
     *
     * @return array
     */
    public static function get()
    {
        $languagesFormatted = [];

        $languages = Language::where('active', 1)->pluck('name', 'code');

        foreach ($languages as $code => $name) {
            $languagesFormatted[$code] = $name;
        }

        return $languagesFormatted;
    }
}
