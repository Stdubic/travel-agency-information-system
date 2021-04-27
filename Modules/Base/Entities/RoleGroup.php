<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleGroup extends Model
{
    protected $fillable = ['name'];

    /**
     * Role group has many roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'group_id', 'id');
    }
}
