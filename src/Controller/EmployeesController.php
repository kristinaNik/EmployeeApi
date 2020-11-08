<?php

namespace App\Controller;

use App\Factories\ClientFactory;
use App\Services\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeesController extends AbstractController
{
    private $service;

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
     * @Route("api/employee/{id}", methods={"GET"}, name="show_employee")
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

}
