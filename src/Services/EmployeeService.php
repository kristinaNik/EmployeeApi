<?php


namespace App\Services;

use App\Dto\Transformers\EmployeeResponseTransformer;
use App\Entity\Employee;
use App\Interfaces\EmployeeInterfaceService;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService implements EmployeeInterfaceService
{

    /**
     * @var EmployeeRepository
     */
    private $repository;

    /**
     * @var EmployeeResponseTransformer
     */
    private $transformer;

    /**
     * EmployeeService constructor.
     *
     * @param EmployeeRepository $repository
     * @param EmployeeResponseTransformer $transformer
     */
    public function __construct(EmployeeRepository $repository, EmployeeResponseTransformer $transformer)
    {
        $this->repository = $repository;
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
            $this->repository->saveEmployees($employee);
        }

    }


    /**
     * @return iterable
     */
    public function getAllEmployees()
    {
        $employees = $this->repository->findAll();

        return ['results' => $this->transformer->transformFromObjects($employees), 'count-employees' => count($employees)];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function showEmployee(int $id): array
    {
        $employeeRepo = $this->repository->find($id);

        if ($employeeRepo instanceof Employee) {
            return ['results' => $this->transformer->transformFromObject($employeeRepo)];
        }
    }

    /**
     * @param $employee
     * @return array
     */
    public function createEmployees(Employee $employee): array
    {
        $employee->setUuid(uniqid());

        $this->repository->create($employee);

        return ['results' => $this->transformer->transformFromObject($employee)];
    }


    /**
     * @param Employee $employee
     * @param $id
     *
     * @return array
     */
    public function updateEmployees(Employee $employee, int $id): array
    {
        $employeeRepo = $this->repository->find($id);

        $employeeRepo->setUuid(uniqid());
        $employeeRepo->setName($employee->getName());
        $employeeRepo->setTitle($employee->getTitle());
        $employeeRepo->setBio($employee->getBio());
        $employeeRepo->setCompany($employee->getCompany());
        $employeeRepo->setAvatar($employee->getAvatar());
        $employeeRepo->setCompany($employee->getCompany());

        $this->repository->update($employeeRepo);

        if ($employeeRepo instanceof Employee) {
            return ['results' => $this->transformer->transformFromObject($employeeRepo)];
        }

    }

    /**
     * @param int $id
     */
    public function deleteEmployees(int $id): void
    {
        $employee = $this->repository->find($id);

        $this->repository->delete($employee);
    }
}