<?php


namespace App\Dto;


class ApiConfigurationDto
{

    /**
     * @var
     */
    private $username;

    /**
     * @var
     */
    private $password;


    /**
     * ApiConfigurationDto constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function create($username, $password)
    {
        return new self($username, $password);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

}