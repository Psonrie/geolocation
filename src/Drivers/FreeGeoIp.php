<?php

namespace Psonrie\GeoLocation\Drivers;

use Exception;
use Illuminate\Support\Fluent;
use Psonrie\GeoLocation\Response;

class FreeGeoIp extends Driver
{
    /**
     * {@inheritdoc}
     */
    protected function url($ip)
    {
        return "https://freegeoip.app/json/$ip";
    }

    /**
     * {@inheritdoc}
     */
    protected function hydrate(Response $response, Fluent $geoLocation)
    {
        $response->countryCode = $geoLocation->country_code;
        $response->countryName = $geoLocation->country_name;
        $response->regionCode  = $geoLocation->region_code;
        $response->regionName  = $geoLocation->region_name;
        $response->cityName    = $geoLocation->city;
        $response->zipCode     = $geoLocation->zip_code;
        $response->timeZone    = $geoLocation->time_zone;
        $response->latitude    = (string) $geoLocation->latitude;
        $response->longitude   = (string) $geoLocation->longitude;
        $response->metroCode   = $geoLocation->metro_code;

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    protected function request($ip)
    {
        try {
            $response = json_decode($this->executeRequest($this->url($ip)), true);

            return new Fluent($response);
        } catch (Exception $e) {
            return false;
        }
    }
}
