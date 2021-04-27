<?php

namespace Modules\Accommodation\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AccommodationObjectScope implements Scope
{

    /**
     * Filter accommodation objects by owner
     *
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if(!$user->can('manager-permission')) {
                $builder->where('supplier_id', auth()->id());
            }
        }
    }
}
