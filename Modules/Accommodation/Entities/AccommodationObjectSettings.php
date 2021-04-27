<?php

namespace Modules\Accommodation\Entities;

use Illuminate\Database\Eloquent\Model;

class AccommodationObjectSettings extends Model
{
    protected $fillable = ['sojourn_tax', 'front_visibility', 'admin_visibility', 'recommendation', 'rating', 'medical', 'household'];
}
