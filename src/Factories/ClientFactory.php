<?php


namespace App\Factories;


use App\Dto\ApiConfigurationDto;
use App\Handlers\ConfigHandler;
use App\Services\ApiClientService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;

class ClientFactory
{

    public static function createClient() {
        return new ApiClientService(
            HttpClient::create(),
            new HttpOptions()
        );
    }

}