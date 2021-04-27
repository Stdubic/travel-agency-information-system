<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    protected $fillable = ['text_field', 'amenity_set_id'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AmenityTranslation';

    /**
     * Amenities belongs to amenity sets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function amenitySets()
    {
        return $this->belongsTo(AmenitySet::class,  'amenity_set_id', 'id');
    }
}
