<?php

namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface
{
    public function getAllStudents();
    public function createStudent(array $request);
    public function getStudentById($student);
    public function updateStudent(array $request, $student);
    public function forceDeleteStudent($student);
}
