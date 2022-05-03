<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getAllEmployees();
    public function createEmployee(array $request);
    public function getEmployeeById($employee);
    public function updateEmployee(array $request, $employee);
    public function forceDeleteEmployee($employee);
}
