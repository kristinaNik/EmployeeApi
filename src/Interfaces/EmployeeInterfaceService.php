<?php


namespace App\Interfaces;


use App\Entity\Employee;

interface EmployeeInterfaceService
{
    public function saveEmployees($contents): void;
    public function getAllEmployees();
    public function showEmployee(int $id): array;
    public function createEmployees(Employee $employee): array;
    public function updateEmployees(Employee $employee, int $id): array;
    public function deleteEmployees(int $id): void;


}