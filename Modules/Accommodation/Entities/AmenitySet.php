<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AmenitySet extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'description'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AmenitySetTranslation';

    /**
     * Amenity set has many amenities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function amenities()
    {
        return $this->hasMany(Amenity::class,   'amenity_set_id', 'id');
    }
}
