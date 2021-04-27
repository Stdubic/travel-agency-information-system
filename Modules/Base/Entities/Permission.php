<?php

namespace Modules\Base\Entities;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'display_name', 'guard_name', 'group_id'];
}
