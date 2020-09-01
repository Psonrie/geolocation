<?php

namespace Psonrie\GeoLocation\Drivers;

use Illuminate\Support\Fluent;
use Psonrie\GeoLocation\Response;

abstract class Driver
{
    /**
     * Returns the URL to use for querying the current driver.
     *
     * @param string $ip
     *
     * @return string
     */
    abstract protected function url($ip);

    /**
     * Hydrates the Response object with the given geo-location data.
     *
     * @param Response $response
     * @param Fluent   $geoLocation
     *
     * @return \Psonrie\GeoLocation\Response
     */
    abstract protected function hydrate(Response $response, Fluent $geoLocation);

    /**
     * Request the specified driver for this IP.
     *
     * @param string $ip
     *
     * @return Fluent|bool
     */
    abstract protected function request($ip);

    /**
     * Handle the driver request.
     *
     * @param string $ip
     *
     * @return Response|bool
     */
    public function get($ip)
    {
        $data = $this->request($ip);

        $response = $this->hydrate($this->getNewResponse(), $data);

        if (!$response->isEmpty()) {
            $response->ip = $ip;

            return $response;
        }

        return false;
    }

    /**
     * Create a new response instance.
     *
     * @return Response|mixed
     */
    protected function getNewResponse()
    {
        $response = config('geo-location.response', Response::class);

        return new $response();
    }

    /**
     * Execute request from the given URL using cURL.
     *
     * @param string $url
     *
     * @return mixed
     */
    protected function executeRequest($url)
    {
        $session = curl_init();

        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_ENCODING, "");
        curl_setopt($session, CURLOPT_MAXREDIRS, 10);
        curl_setopt($session, CURLOPT_TIMEOUT, 5);
        curl_setopt($session, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt(
            $session,
            CURLOPT_HTTPHEADER,
            [
                "accept: application/json",
                "content-type: application/json",
            ]
        );

        $content = curl_exec($session);

        curl_close($session);

        return $content;
    }
}
