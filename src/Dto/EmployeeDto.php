<?php


namespace App\Dto;


use Symfony\Component\Serializer\Annotation\SerializedName;

class EmployeeDto
{

    /**
     * @SerializedName("uuid")
     */
    public $uuid;


    /**
     * @SerializedName("company")
     */
    public $company;

    /**
     * @SerializedName("bio")
     */
    public $bio;


    /**
     * @SerializedName("name")
     */
    public $name;


    /**
     * @SerializedName("title")
     */
    public $title;


    /**
     * @SerializedName("avatar")
     */
    public $avatar;

    /**
     * @SerializedName("createdAt")
     */
    public $createdAt;

    /**
     * @SerializedName("updatedAt")
     */
    public $updatedAt;

}