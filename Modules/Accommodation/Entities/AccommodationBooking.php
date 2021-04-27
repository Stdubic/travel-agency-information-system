<?php

namespace Modules\Accommodation\Entities;

use Illuminate\Database\Eloquent\Model;

class AccommodationBooking extends Model
{
    protected $fillable = [
        'accommodation_object_id',
        'accommodation_unit_id',
        'rate_plan_id',
        'client_id',
        'guests',
        'start',
        'end',
        'status'
    ];
}
