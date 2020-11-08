<?php


namespace App\Handlers;


use App\Dto\ApiConfigurationDto;

class ConfigHandler
{
    /**
     * @var string
     */
    private $username = 'hard';

    /**
     * @var string
     */
    private $password = 'hard';

    /**
     * @return ApiConfigurationDto
     */
    public function handle(): ApiConfigurationDto
    {
        return ApiConfigurationDto::create($this->username, $this->password);
    }
}