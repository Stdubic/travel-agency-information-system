<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccommodationCategory extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AccommodationCategoryTranslation';

    /**
     * Belongs to many objects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function objects()
    {
        return $this->belongsToMany(AccommodationObject::class, 'accommodation_object_category_pivot', 'accommodation_category_id', 'accommodation_object_id');
    }
}
