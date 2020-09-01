<?php

namespace Psonrie\GeoLocation;

use Illuminate\Support\ServiceProvider;

class GeoLocationServiceProvider extends ServiceProvider
{
    /**
     * Boot operations.
     *
     * @return void
     */
    public function boot()
    {
        $config = __DIR__ . '/Config/config.php';

        $this->publishes(
            [
                $config => config_path('geo-location.php'),
            ]
        );

        $this->mergeConfigFrom($config, 'geo-location');
    }

    /**
     * Register the geo-location binding.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('geo-location', GeoLocation::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['geo-location'];
    }
}
