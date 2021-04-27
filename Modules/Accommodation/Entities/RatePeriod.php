<?php

namespace Modules\Accommodation\Entities;

use Illuminate\Database\Eloquent\Model;

class RatePeriod extends Model
{
    protected $fillable = [
        'rate_id',
        'period',
        'price',
        'rooms_to_sell',
        'minimum_stay',
    ];
}
