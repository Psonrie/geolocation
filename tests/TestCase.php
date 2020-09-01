<?php

namespace Psonrie\GeoLocation\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Psonrie\GeoLocation\GeoLocationServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [GeoLocationServiceProvider::class];
    }
}
