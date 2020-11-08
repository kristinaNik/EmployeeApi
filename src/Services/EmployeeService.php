<?php


namespace App\Services;

use App\Dto\Transformers\EmployeeResponseTransformer;
use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;


    private $transformer;

    /**
     * EmoloyeeService constructor.
     * @param EntityManagerInterface $entityManager
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
    public function createEmployees($content)
    {
        $employee = new Employee();

        $employee->setUuid(uniqid());
        $employee->setName($content->getName());
        $employee->setTitle($content->getTitle());
        $employee->setBio($content->getBio());
        $employee->setCompany($content->getCompany());
        $employee->setAvatar($content->getAvatar());
        $employee->setCompany($content->getCompany());

        $this->em->persist($employee);
        $this->em->flush();

        return $this->transformer->transformFromObject($employee);
    }
}