<?php


namespace App\Factories;

use App\Services\ApiClientService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;

class ClientFactory
{

    /**
     * @return ApiClientService
     */
    public static function createClient(): ApiClientService
    {
        return new ApiClientService(
            HttpClient::create(),
            new HttpOptions()
        );
    }

}