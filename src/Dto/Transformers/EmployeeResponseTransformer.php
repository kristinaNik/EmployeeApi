<?php


namespace App\Dto\Transformers;


use App\Dto\EmployeeDto;
use App\Entity\Employee;

class EmployeeResponseTransformer extends AbstractResponseDtoTransformer
{

    /**
     * @param Employee $employee
     * @return EmployeeDto
     */
    public function transformFromObject($employee): EmployeeDto
    {
        $dto = new EmployeeDto();
        $dto->uuid = $employee->getUuid();
        $dto->company = $employee->getCompany();
        $dto->bio = $employee->getBio();
        $dto->name = $employee->getName();
        $dto->title = $employee->getTitle();
        $dto->avatar = $employee->getAvatar();
        $dto->createdAt = $employee->getCreatedAt();
        $dto->updatedAt = $employee->getUpdatedAt();

        return $dto;
    }

}