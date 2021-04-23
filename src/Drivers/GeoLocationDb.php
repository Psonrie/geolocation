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
        return "http://geolocation-db.com/json/$ip";
    }

    /**
     * {@inheritdoc}
     */
    protected function request($ip)
    {
        $driverResponse = null;

        $content = $this->executeRequest($this->url($ip));

        if (is_string($content)) {
            $driverResponse = json_decode($content, true);
        }

        if (null === $driverResponse) {
            throw new AddressNotFoundException("The IP address {$ip} could not be found.");
        }

        return new Response($driverResponse);
    }
}
