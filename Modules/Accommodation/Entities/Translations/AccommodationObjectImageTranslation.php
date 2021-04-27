<?php

namespace Modules\Accommodation\Entities\Translations;

use Illuminate\Database\Eloquent\Model;

class AccommodationObjectImageTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['alt', 'description'];
}
