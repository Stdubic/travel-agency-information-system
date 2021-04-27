<?php

namespace Modules\Accommodation\Entities\Translations;

use Illuminate\Database\Eloquent\Model;

class AmenitySetTranslation extends Model
{
    public $timestamps = true;

    protected $fillable = ['title', 'description', 'locale'];
}
