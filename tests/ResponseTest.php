<?php

namespace Psonrie\GeoLocation\Tests;

use Mockery;
use Psonrie\GeoLocation\Drivers\Driver;
use Psonrie\GeoLocation\Drivers\FreeGeoIp;
use Psonrie\GeoLocation\Exceptions\DriverDoesNotExistException;
use Psonrie\GeoLocation\Facades\GeoLocation;
use Psonrie\GeoLocation\Response;

class ResponseTest extends TestCase
{
    const TEST_IP = '66.102.0.0';

    public function testDriverRequest()
    {
        $driver = Mockery::mock(Driver::class);

        GeoLocation::setDriver($driver);

        $attributes = $this->emptyAttributes();

        $attributes['city'] = 'test';

        $response = new Response($attributes);

        $driver
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('request')->once()->andReturn($response);

        $this->assertEquals($response, GeoLocation::get(self::TEST_IP));
    }

    public function testDriverDoesNotExist()
    {
        config(['geo-location.driver' => 'Test']);

        $this->expectException(DriverDoesNotExistException::class);

        GeoLocation::get(self::TEST_IP);
    }

    public function testFreeGeoIp()
    {
        $driver = Mockery::mock(FreeGeoIp::class)->makePartial();

        $attributes = [
            'ip'           => self::TEST_IP,
            'country_code' => 'US',
            'country_name' => 'United States',
            'state'        => '',
            'city'         => '',
            'postal'       => '',
            'latitude'     => 37.751,
            'longitude'    => -97.822,
        ];

        $driver
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('request')->once()->andReturn(new Response($attributes));

        GeoLocation::setDriver($driver);

        $response = GeoLocation::get(self::TEST_IP);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(
            [
                'countryCode' => 'US',
                'countryName' => 'United States',
                'state'        => '',
                'city'         => '',
                'postal'       => '',
                'latitude'     => '37.751',
                'longitude'    => '-97.822',
                'ip'           => self::TEST_IP,
            ],
            $response->toArray()
        );
    }

    public function testResponseIsEmpty()
    {
        $attributes = $this->emptyAttributes();

        $attributes['ip'] = self::TEST_IP;

        $response = new Response($attributes);

        $this->assertTrue($response->isEmpty());
    }

    public function testResponseIsNotEmpty()
    {
        $attributes = $this->emptyAttributes();

        $attributes['country_name'] = 'test';

        $response = new Response($attributes);

        $this->assertFalse($response->isEmpty());
    }

    /**
     * Return empty attributes to construct a Response
     *
     * @return array
     */
    private function emptyAttributes()
    {
        return [
            'ip'           => null,
            'country_code' => null,
            'country_name' => null,
            'state'        => null,
            'city'         => null,
            'postal'       => null,
            'latitude'     => null,
            'longitude'    => null,
        ];
    }
}
