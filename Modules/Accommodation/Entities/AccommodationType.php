<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Entities\Translations\AccommodationTypeTranslation;

class AccommodationType extends Model
{
    use Translatable;

    protected $fillable = ['standard_capacity', 'max_capacity', 'min_capacity', 'max_adults', 'min_children', 'description'];

    public $translatedAttributes = ['title'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AccommodationTypeTranslation';
}
