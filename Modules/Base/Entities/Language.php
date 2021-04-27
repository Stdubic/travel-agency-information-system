<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['code', 'name', 'active'];

    public $timestamps = false;
}
