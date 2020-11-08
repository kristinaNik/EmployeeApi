<?php


namespace App\Services;

use App\Handlers\ConfigHandler;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClientService
{

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var HttpOptions
     */
    private $options;


    public const API_URL = 'http://hiring.rewardgateway.net/list';

    /**
     * ApiClientService constructor.
     * @param HttpClientInterface $client
     * @param HttpOptions $options
     */
    public function __construct(HttpClientInterface $client,HttpOptions $options)
    {
        $this->client = $client;
        $this->options = $options;
    }


    /**
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getEmployeeList()
    {
        $options = $this->configurationOptions();
        $response = $this->client->request('POST', self::API_URL, $options->toArray());
        $content =  $response->getContent();

        return json_decode($content);
    }


    /**
     * @return HttpOptions
     */
    private function configurationOptions(): HttpOptions
    {
        $configHandler = new ConfigHandler();
        $config = $configHandler->handle();

        $headers  =  [ 'Content-Type' => 'json'];
        $this->options->setHeaders($headers);
        $this->options->setAuthBasic($config->getUsername(), $config->getPassword());

        return $this->options;
    }
}