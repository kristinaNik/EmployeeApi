<?php

namespace App\Controller;

use App\Controller\Traits\ValidationTrait;
use App\Entity\Employee;
use App\Factories\ClientFactory;
use App\Interfaces\EmployeeInterfaceService;
use App\Services\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeesController extends AbstractController
{
    use ValidationTrait;

    /**
     * @var EmployeeInterfaceService
     */
    private $service;

    /**
     * EmployeesController constructor.
     * @param EmployeeInterfaceService $service
     */
    public function __construct(EmployeeInterfaceService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Post("/save/employees")

     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function saveAction(): JsonResponse
    {
        $clientFactory= ClientFactory::createClient()->getEmployeeList();

        $this->service->saveEmployees($clientFactory);

        return $this->json(['message' => 'Employees saved'],201);

    }

    /**
     * @Rest\Get("/employees")
     *
     * @return JsonResponse
     */
    public function getAllAction(): JsonResponse
    {
        $employees = $this->service->getAllEmployees();

        return $this->json($employees, 200);
    }

    /**
     * @Rest\Get("/employees/{id}")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function showAction(int $id): JsonResponse
    {
        $employee = $this->service->showEmployee($id);

        if ($employee === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        return  $this->json($employee, 200);
    }

    /**
     * @Rest\Post("/employees")
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function postAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        $employeeResponse = $serializer->deserialize($data, Employee::class, 'json');

        $errors  = $validator->validate($employeeResponse);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        if (!$employeeResponse instanceof Employee) {
            throw new \Exception("This object does not belong to the given class");
        }

        $response = $this->service->createEmployees($employeeResponse);

        return $this->json($response, 201, []);
    }

    /**
     * @Rest\Put("/employees/{id}")
     *
     * @param Request $request
     * @param int $id
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateAction(Request $request, int $id, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        if ($this->service->showEmployee($id) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $data = $request->getContent();
        $employeeResponse = $serializer->deserialize($data, Employee::class, 'json');
        $errors  = $validator->validate($employeeResponse);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        if (!$employeeResponse instanceof Employee) {
            throw new \Exception("This object does not belong to the given class");
        }

        $response = $this->service->updateEmployees($employeeResponse, $id);

        return $this->json($response, 201, []);
    }

    /**
     * @Rest\Delete("/employees/{id}")
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request, int $id): JsonResponse
    {
        if ($this->service->showEmployee($id) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $this->service->deleteEmployees($id);

        return $this->json(['message' => 'Resource successfully deleted'], 200, []);
    }
}
