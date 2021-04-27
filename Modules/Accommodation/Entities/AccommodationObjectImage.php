<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AccommodationObjectImage extends Model
{
    use Translatable;

    protected $fillable = ['unique_id'];

    public $timestamps = false;

    public $translatedAttributes = ['alt', 'description'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AccommodationObjectImageTranslation';

    /**
     * Accommodation object image belongs to object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function object()
    {
        return $this->belongsTo(AccommodationObject::class, 'accommodation_object_id', 'id');
    }
}
