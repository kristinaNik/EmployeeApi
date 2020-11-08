<?php


namespace App\Handlers;


use App\Dto\ApiConfigurationDto;

class ConfigHandler
{
    private $username = 'hard';
    private $password = 'hard';

    public function handle()
    {
        return ApiConfigurationDto::create($this->username, $this->password);
    }
}