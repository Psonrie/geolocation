<?php

namespace Psonrie\GeoLocation\Tests;

use Illuminate\Support\Fluent;
use Mockery;
use Psonrie\GeoLocation\Drivers\Driver;
use Psonrie\GeoLocation\Drivers\FreeGeoIp;
use Psonrie\GeoLocation\Exceptions\DriverDoesNotExistException;
use Psonrie\GeoLocation\Facades\GeoLocation;
use Psonrie\GeoLocation\Response;

class ResponseTest extends TestCase
{
    public function testDriverRequest()
    {
        $driver = Mockery::mock(Driver::class);

        GeoLocation::setDriver($driver);

        $response           = new Response();
        $response->cityName = 'test';

        $driver
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('request')->once()->andReturn(new Fluent(['test']))
            ->shouldReceive('hydrate')->once()->andReturn($response);

        $this->assertEquals($response, GeoLocation::get('66.102.0.0'));
    }

    public function testDriverDoesNotExist()
    {
        config(['geo-location.driver' => 'Test']);

        $this->expectException(DriverDoesNotExistException::class);

        GeoLocation::get('66.102.0.0');
    }

    public function testFreeGeoIp()
    {
        $driver = Mockery::mock(FreeGeoIp::class)->makePartial();

        $attributes = [
            'country_code' => 'US',
            'country_name' => 'United States',
            'region_code'  => '',
            'region_name'  => '',
            'city'         => '',
            'zip_code'     => '',
            'time_zone'    => 'America/Chicago',
            'latitude'     => 37.751,
            'longitude'    => -97.822,
            'metro_code'   => 0,
        ];

        $driver
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('request')->once()->andReturn(new Fluent($attributes));

        GeoLocation::setDriver($driver);

        $response = GeoLocation::get('66.102.0.0');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            [
                'countryCode' => 'US',
                'countryName' => 'United States',
                'regionCode'  => '',
                'regionName'  => '',
                'cityName'    => '',
                'zipCode'     => '',
                'timeZone'    => 'America/Chicago',
                'latitude'    => '37.751',
                'longitude'   => '-97.822',
                'metroCode'   => 0,
                'ip'          => '66.102.0.0',
            ],
            $response->toArray()
        );
    }

    public function testResponseIsEmpty()
    {
        $response = new Response();

        $response->ip = '66.102.0.0';
        $this->assertTrue($response->isEmpty());
    }

    public function testResponseIsNotEmpty()
    {
        $response = new Response();

        $response->countryCode = 'test';
        $this->assertFalse($response->isEmpty());
    }
}
