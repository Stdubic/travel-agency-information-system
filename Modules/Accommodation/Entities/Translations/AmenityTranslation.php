<?php

namespace Modules\Accommodation\Entities\Translations;

use Illuminate\Database\Eloquent\Model;

class AmenityTranslation extends Model
{
    public $timestamps = true;

    protected $fillable = ['title', 'locale'];
}
