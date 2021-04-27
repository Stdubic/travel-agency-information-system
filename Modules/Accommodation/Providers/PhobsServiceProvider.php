<?php

namespace Modules\Accommodation\Providers;

use Modules\Accommodation\Services\PhobsRequestBuilder;
use Modules\Accommodation\Services\SoapPhobsClient;
use Illuminate\Support\ServiceProvider;

class PhobsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
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
}
