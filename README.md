# Geo Location

Laravel service provider to retrieve a users location from their IP address using [freegeoip.app](https://freegeoip.app/) service.

## Requirements

- Laravel >= 5
- PHP 7.0 or greater
- cURL extension enabled

## Installation

Via Composer

```bash
composer require psonrie/geolocation
```

> **Note**: If you're using Laravel 5.5 or above, you can skip the registration
> of the service provider, as it is registered automatically.

Add the service provider in `config/app.php`:

```php
Psonrie\GeoLocation\GeoLocationServiceProvider::class,
```

Publish the config file:

```bash
php artisan vendor:publish --provider="Psonrie\GeoLocation\GeoLocationServiceProvider"
```

## Usage

#### Retrieving a users location

```php
$response = GeoLocation::get('46.24.247.56');

// Returns instance of Psonrie\GeoLocation\Response

Psonrie\GeoLocation\Response {
  ip: "46.24.247.56"
  countryCode: "ES"
  countryName: "Spain"
  regionCode: "CT"
  regionName: "Catalonia"
  cityName: "Barcelona"
  zipCode: "08004"
  timeZone: "Europe/Madrid"
  latitude: "41.3891"
  longitude: "2.1611"
  metroCode: 0
}
```

## Contribute

Contributions are welcome! Send a pull request to the [main repository](https://github.com/Psonrie/geolocation) or 
report any issues you find on the [issue tracker](https://github.com/Psonrie/geolocation/issues).

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
