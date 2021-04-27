<?php

namespace Modules\Accommodation\Entities\Translations;

use Illuminate\Database\Eloquent\Model;

class AccommodationObjectDescriptionTranslation extends Model
{
    public $timestamps = true;

    protected $fillable = ['description', 'locale'];
}
