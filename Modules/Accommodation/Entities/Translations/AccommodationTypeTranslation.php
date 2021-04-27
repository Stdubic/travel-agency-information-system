<?php

namespace Modules\Accommodation\Entities\Translations;

use Illuminate\Database\Eloquent\Model;

class AccommodationTypeTranslation extends Model
{
    public $timestamps = true;

    protected $fillable = ['title', 'locale'];
}
