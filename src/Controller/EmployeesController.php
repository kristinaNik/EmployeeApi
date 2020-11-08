<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Factories\ClientFactory;
use App\Services\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeesController extends AbstractController
{
    /**
     * @var EmployeeService
     */
    private $service;

    /**
     * EmployeesController constructor.
     * @param EmployeeService $service
     */
    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("api/save/employees", methods={"POST"}, name="save_employees")

     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function saveEmployees(): JsonResponse
    {
        $clientFactory= ClientFactory::createClient()->getEmployeeList();

        $this->service->saveEmployees($clientFactory);

        return $this->json(['message' => 'Employees saved'],201);

    }

    /**
     * @Route("api/employees", methods={"GET"}, name="get_all_employees")
     * @return JsonResponse
     */
    public function getEmployees(): JsonResponse
    {
        $employees = $this->service->getAllEmployees();

        return $this->json($employees, 200);
    }

    /**
     * @Route("api/employees/{id}", methods={"GET"}, name="show_employee")
     * @param $id
     * @return JsonResponse
     */
    public function showEmployee($id): JsonResponse
    {
        $employee = $this->service->showEmployee($id);

        if ($employee === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        return  $this->json($employee, 200);
    }

    /**
     * @Route("api/employees", methods={"POST"}, name="create_employees")
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function createEmployee(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = $request->getContent();
        $json = $serializer->deserialize($data, Employee::class, 'json');

        $response = $this->service->createEmployees($json);

        return $this->json($response, 201, []);
    }


    /**
     * @Route("api/employees/{id}", methods={"PUT"}, name="update_employee")
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function updateEmployee(Request $request, $id, SerializerInterface $serializer): JsonResponse
    {
        if ($this->service->showEmployee($id) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $data = $request->getContent();
        $json = $serializer->deserialize($data, Employee::class, 'json');

        $response = $this->service->upateEmployees($json, $id);

        return $this->json($response, 201, []);
    }

    /**
     * @Route("api/employees/{id}", methods={"DELETE"}, name="delete_employee")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteEmployee(Request $request, $id): JsonResponse
    {
        if ($this->service->showEmployee($id) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $this->service->deleteEmployees($id);

        return $this->json(['message' => 'Resource successfully deleted'], 200, []);
    }
}
