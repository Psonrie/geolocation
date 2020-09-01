<?php

namespace Psonrie\GeoLocation;

use Psonrie\GeoLocation\Drivers\Driver;
use Psonrie\GeoLocation\Exceptions\DriverDoesNotExistException;

class GeoLocation
{
    /**
     * The current driver.
     *
     * @var Driver
     */
    protected $driver;

    /**
     * Constructor.
     *
     * @throws DriverDoesNotExistException
     */
    public function __construct()
    {
        $driver = $this->getDriver();

        $this->setDriver($driver);
    }

    /**
     * Creates the selected driver instance and sets the driver property.
     *
     * @param Driver $driver
     *
     * @return void
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Retrieve the users geo-location.
     *
     * @param string $ip
     *
     * @return \Psonrie\GeoLocation\Response|bool
     */
    public function get($ip)
    {
        return $this->driver->get($ip);
    }

    /**
     * Returns the default driver.
     *
     * @return Driver|mixed
     *
     * @throws DriverDoesNotExistException
     */
    protected function getDriver()
    {
        $driver = config('geo-location.driver');

        if (!class_exists($driver)) {
            throw new DriverDoesNotExistException('The geo-location driver ' .  $driver . ' does not exist.');
        }

        return new $driver();
    }
}
