<?php


namespace App\Services;

use App\Dto\EmployeeDto;
use App\Dto\Transformers\EmployeeResponseTransformer;
use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EmployeeResponseTransformer
     */
    private $transformer;

    /**
     * EmployeeService constructor.
     * @param EntityManagerInterface $entityManager
     * @param EmployeeResponseTransformer $transformer
     */
    public function __construct(EntityManagerInterface $entityManager, EmployeeResponseTransformer $transformer)
    {
        $this->em = $entityManager;
        $this->transformer = $transformer;
    }


    /**
     * @param $contents
     */
    public function saveEmployees($contents): void
    {
        foreach ($contents as $content) {
            $employee = new Employee();
            $employee->setUuid($content->uuid);
            $employee->setName($content->name);
            $employee->setTitle($content->title);
            $employee->setBio($content->bio);
            $employee->setCompany($content->company);
            $employee->setAvatar($content->avatar);
            $this->em->persist($employee);
            $this->em->flush();
        }

    }


    /**
     * @return iterable
     */
    public function getAllEmployees()
    {
        $employees = $this->em->getRepository(Employee::class)->findAll();

        return $this->transformer->transformFromObjects($employees);
    }

    /**
     * @param $id
     * @return \App\Dto\EmployeeDto
     */
    public function showEmployee($id)
    {
        $employee = $this->em->getRepository(Employee::class)->find($id);

        if ($employee instanceof Employee) {
            return $this->transformer->transformFromObject($employee);
        }
    }

    /**
     * @param $content
     * @return \App\Dto\EmployeeDto
     */
    public function createEmployees($content): EmployeeDto
    {
        $content->setUuid(uniqid());

        $this->em->persist($content);
        $this->em->flush();

        return $this->transformer->transformFromObject($content);
    }


    /**
     * @param $content
     * @return \App\Dto\EmployeeDto
     */
    public function upateEmployees($content, $id): EmployeeDto
    {
        $employee = $this->em->getRepository(Employee::class)->find($id);

        $employee->setUuid(uniqid());
        $employee->setName($content->getName());
        $employee->setTitle($content->getTitle());
        $employee->setBio($content->getBio());
        $employee->setCompany($content->getCompany());
        $employee->setAvatar($content->getAvatar());
        $employee->setCompany($content->getCompany());

        $this->em->persist($employee);
        $this->em->flush();

        if ($employee instanceof Employee) {
            return $this->transformer->transformFromObject($employee);
        }

    }

    /**
     * @param $id
     */
    public function deleteEmployees($id): void
    {
        $employee = $this->em->getRepository(Employee::class)->find($id);

        $this->em->remove($employee);
        $this->em->flush();
    }
}