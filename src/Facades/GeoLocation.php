<?php

namespace Psonrie\GeoLocation\Facades;

use Illuminate\Support\Facades\Facade;
use Psonrie\GeoLocation\Drivers\Driver;
use Psonrie\GeoLocation\Response;

/**
 * @method static Response|bool get(string $ip)
 * @method static void setDriver(Driver $driver)
 *
 * @see \Psonrie\GeoLocation\GeoLocation
 */
class GeoLocation extends Facade
{
    /**
     * The IoC key accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'geo-location';
    }
}
