<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccommodationUnitType extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AccommodationUnitTypeTranslation';
}
