<?php

namespace Modules\Accommodation\Entities;

use Illuminate\Database\Eloquent\Model;

class RatePlan extends Model
{
    protected $fillable = [
        'accommodation_object_id',
        'code',
        'name',
        'service',
        'type',
        'base_price',
        'b2c_margin_type',
        'b2c_margin',
        'min_person',
        'min_stay',
        'max_stay',
        'release_period',
        'sojourn_tax',
        'currency',
        'imported',
        'start',
        'stop'
    ];

    /**
     * Base price accessor
     *
     * @param $value
     * @return mixed
     */
    public function getBasePrice($value)
    {
        return unserialize($value);
    }

    /**
     * Base price mutator
     *
     * @param $value
     */
    public function setBasePrice($value)
    {
        $this->attributes['base_price'] = serialize($value);
    }

    /**
     * Units belongs to object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function object()
    {
        return $this->belongsTo(AccommodationObject::class, 'accommodation_object_id', 'id');
    }

    /**
     * Rate plans belongs to many accommodation units
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function units()
    {
        return $this->belongsToMany(AccommodationUnit::class, 'room_rate_unit_pivot', 'rate_plan_id', 'accommodation_unit_id');
    }

    /**
     * One rate plan has many periods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods()
    {
        return $this->hasMany(RatePeriod::class, 'rate_id', 'id');
    }
}
