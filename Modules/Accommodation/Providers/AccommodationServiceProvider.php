<?php

namespace Modules\Accommodation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Accommodation\Services\PhobsRequestBuilder;
use Modules\Accommodation\Services\SoapPhobsClient;
use Rinvex\Attributes\Models\Attribute;
use Rinvex\Attributes\Models\Type\Boolean;
use Rinvex\Attributes\Models\Type\Datetime;
use Rinvex\Attributes\Models\Type\Integer;
use Rinvex\Attributes\Models\Type\Text;
use Rinvex\Attributes\Models\Type\Varchar;
use Illuminate\Support\Facades\Validator;

class AccommodationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->registerValidations();
    }


    /**
     *
     */
    protected function registerValidations()
    {
        Validator::extend('inObject', 'Modules\Accommodation\Validators\CustomValidator@inObject');
        Validator::replacer('inObject', 'Modules\Accommodation\Validators\CustomValidator@inObjectReplacer');

        Validator::extend('forPlan', 'Modules\Accommodation\Validators\CustomValidator@forPlan');
        Validator::replacer('forPlan', 'Modules\Accommodation\Validators\CustomValidator@forPlanReplacer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->mergeNavbar(
            __DIR__.'/../Config/navbar.php','navbar'
        );

        $this->app->bind(PhobsRequestBuilder::class, function()
        {
            $domDoc = new \DOMDocument('999');
            $domDoc->formatOutput = true;

            return new PhobsRequestBuilder($domDoc);
        });


        $this->app->bind(SoapPhobsClient::class, function()
        {
            $domDoc = new \DOMDocument('999');
            $domDoc->formatOutput = true;

            $requestBuilder = new PhobsRequestBuilder($domDoc);

            return new SoapPhobsClient($requestBuilder);
        });
    }

    /**
     * Merge module navbar
     *
     * @param $path
     * @param $key
     */
    protected function mergeNavbar($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge($config, require $path));
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('accommodation.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'accommodation'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/accommodation');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/accommodation';
        }, \Config::get('view.paths')), [$sourcePath]), 'accommodation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/accommodation');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'accommodation');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'accommodation');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
