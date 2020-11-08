<?php


namespace App\Collections;

use Symfony\Component\Serializer\Annotation\SerializedName;

class EmployeeCollection
{
    /**
     * @SerializedName("Result")
     * @var \App\Entity\Employee[]
     */
    private $result;

    /**
     * @return \App\Entity\Employee[]
     */
    public function getResult(): ?array
    {
        return $this->result;
    }

    /**
     * @param \App\Entity\Employee[] $results
     */
    public function setResult(array $result)
    {
        $this->result = $result;
    }
}