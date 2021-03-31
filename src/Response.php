<?php

namespace Psonrie\GeoLocation;

use Illuminate\Contracts\Support\Arrayable;

class Response implements Arrayable
{
    /**
     * The IP address used to retrieve the geo-location.
     *
     * @var string
     */
    public $ip;
    /**
     * The country code.
     *
     * @var string|null
     */
    public $countryCode;
    /**
     * The country name.
     *
     * @var string|null
     */
    public $countryName;
    /**
     * The region name.
     *
     * @var string|null
     */
    public $regionName;
    /**
     * The city name.
     *
     * @var string|null
     */
    public $cityName;
    /**
     * The zip code.
     *
     * @var string|null
     */
    public $zipCode;
    /**
     * The latitude.
     *
     * @var string|null
     */
    public $latitude;
    /**
     * The longitude.
     *
     * @var string|null
     */
    public $longitude;

    /**
     * Response constructor.
     *
     * @param array $driverResponse
     */
    public function __construct($driverResponse)
    {
        $this->ip          = $driverResponse['ip'] ?? $driverResponse['IPv4'];
        $this->countryCode = $driverResponse['country_code'];
        $this->countryName = $driverResponse['country_name'];
        $this->regionName  = $driverResponse['state'];
        $this->cityName    = $driverResponse['city'];
        $this->zipCode     = $driverResponse['postal'];
        $this->latitude    = $driverResponse['latitude'];
        $this->longitude   = $driverResponse['longitude'];
    }

    /**
     * Determine if the response is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        $data = $this->toArray();

        unset($data['IPv4']);

        return empty(array_filter($data));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
