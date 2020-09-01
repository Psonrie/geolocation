<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | The default driver you would like to use.
    |
    */

    'driver' => Psonrie\GeoLocation\Drivers\FreeGeoIp::class,

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    |
    | The default response you would like to use.
    |
    */

    'response' => Psonrie\GeoLocation\Response::class,

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    |
    | Parameters used for testing purpose.
    |
    */

    'testing' => [
        'enabled' => env('LOCATION_TESTING', true),
        'ip'      => '66.102.0.0',
    ],

];
