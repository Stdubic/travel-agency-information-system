<?php

namespace Modules\Accommodation\Entities;

use Illuminate\Database\Eloquent\Model;

class AccommodationUnit extends Model
{
    protected $fillable = ['code', 'name', 'imported', 'accommodation_object_id', 'accommodation_unit_type_id', 'basic_bed_number', 'additional_bed_number', 'position', 'view', 'qty', 'rating', 'active', 'sojourn_tax'];


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
     * Accommodation units belongs to many rate plans
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rates()
    {
        return $this->belongsToMany(RatePlan::class, 'room_rate_unit_pivot', 'accommodation_unit_id', 'rate_plan_id');
    }


    /**
     * Accommodation unit belongs to type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AccommodationUnitType::class, 'accommodation_unit_type_id', 'id');
    }

}
