<?php

namespace Modules\Base\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\AccommodationUnit;
use Modules\Accommodation\Policies\AccommodationObjectPolicy;
use Modules\Accommodation\Policies\AccommodationUnitPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AccommodationObject::class => AccommodationObjectPolicy::class,
        AccommodationUnit::class => AccommodationUnitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
