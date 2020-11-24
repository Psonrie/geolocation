<?php

namespace Psonrie\GeoLocation\Drivers;

use Psonrie\GeoLocation\Exceptions\AddressNotFoundException;
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
    protected function request($ip)
    {
        $driverResponse = json_decode($this->executeRequest($this->url($ip)), true);

        if (null === $driverResponse) {
            throw new AddressNotFoundException("The IP address {$ip} could not be found.");
        }

        return new Response($driverResponse);
    }
}
