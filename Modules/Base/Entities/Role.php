<?php

namespace Modules\Base\Entities;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'group_id', 'type'];

    /**
     * Role belongs to group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(RoleGroup::class, 'group_id', 'id');
    }

    /**
     * Roles belongs to many permission groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissionGroups()
    {
        return $this->belongsToMany(PermissionGroup::class, 'role_permission_groups_pivot', 'role_id', 'permission_group_id');
    }
}
