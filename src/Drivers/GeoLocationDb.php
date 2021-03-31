<?php

namespace Psonrie\GeoLocation\Drivers;

use Psonrie\GeoLocation\Exceptions\AddressNotFoundException;
use Psonrie\GeoLocation\Response;

class GeoLocationDb extends Driver
{
    /**
     * {@inheritdoc}
     */
    protected function url($ip)
    {
        return "https://geolocation-db.com/jsonp/$ip";
    }

    /**
     * {@inheritdoc}
     */
    protected function request($ip)
    {
        $driverResponse = json_decode($this->executeRequest($this->url($ip)), true);

        if (null === $driverResponse) {
            throw new AddressNotFoundException("The IP address {$ip} could not be found.");
        }

        return new Response($driverResponse);
    }
}
