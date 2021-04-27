<?php

namespace Modules\Base\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Modules\Base\Services\LanguageConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLangDirective();

        Schema::defaultStringLength(191);
        Schema::enableForeignKeyConstraints();
        Schema::defaultStringLength(191);

        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }

    public function registerLangDirective()
    {
        Blade::directive('lang', function () {
            return LanguageConfig::get();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
