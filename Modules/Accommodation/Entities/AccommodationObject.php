<?php

namespace Modules\Accommodation\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Accommodation\Scopes\AccommodationObjectScope;
use Modules\Base\Entities\User;

class AccommodationObject extends Model
{

    use Translatable;

    public $translatedAttributes = ['description'];

    public $translationModel = 'Modules\Accommodation\Entities\Translations\AccommodationObjectDescriptionTranslation';

    protected $fillable = [
        'name',
        'tel_num',
        'rating',
        'channel_manager',
        'channel_manager_code',
        'type',
        'supplier_id',
        'country_id',
        'region_id',
        'city_id',
        'lat',
        'long',
        'reception_email',
        'booking_email',
        'office_phone',
        'website',
        'address',
        'time_zone',
        'currency',
        'bank_name',
        'bank_office',
        'bank_swift',
        'account_number',
        'company_name',
        'bank_iban',
        'contact_person',
        'added_tax',
        'office_tax',
        'is_synced'
    ];


    /**
     * Accommodation object has many images
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(AccommodationObjectImage::class, 'accommodation_object_id', 'id');
    }

    /**
     * Belongs to many amenity sets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenitySets()
    {
        return $this->belongsToMany(AmenitySet::class, 'accommodation_object_amenity_set_pivot', 'accommodation_object_id', 'amenity_set_id');
    }

    /**
     * Belongs to many amenity sets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'accommodation_object_amenities_pivot', 'accommodation_object_id', 'amenity_id')
            ->withPivot('value');
    }

    /**
     * Belongs to many categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(AccommodationCategory::class, 'accommodation_object_category_pivot', 'accommodation_object_id', 'accommodation_category_id');
    }

    /**
     * Accommodation object settings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne(AccommodationObjectSettings::class, 'accommodation_object_id', 'id');
    }

    /**
     * Accommodation object country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * Accommodation object region
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    /**
     * Accommodation object city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

//    /**
//     * Accommodation object type
//     *
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function type()
//    {
//        return $this->belongsTo(AccommodationType::class, 'type_id', 'id');
//    }

    /**
     * Accommodation object owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    /**
     * Accommodation object rate plans
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratePlans()
    {
        return $this->hasMany(RatePlan::class, 'accommodation_object_id', 'id');
    }

    /**
     * Accommodation object unit types
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany(AccommodationUnit::class, 'accommodation_object_id', 'id');
    }

    /**
     * Add scope to boot
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AccommodationObjectScope());
    }

    /**
     * Owner of the resource scope
     *
     * @param $builder
     */
    public function scopeOwner($builder)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if(!$user->can('manager-permission')) {
                $builder->where('supplier_id', auth()->id());
            }
        }

    }
}
