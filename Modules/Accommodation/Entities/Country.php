<?php

namespace Modules\Accommodation\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name_hr', 'name_en', 'name_ru', 'local_name', 'global_name', 'code', 'dial_code'];

    /**
     * Country has many regions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regions()
    {
        return $this->hasMany(Region::class, 'country_id', 'id');
    }
}
