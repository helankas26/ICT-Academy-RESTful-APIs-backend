<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllStudents()
    {
        // TODO: Implement getAllStudents() method.
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createStudent(array $request)
    {
        // TODO: Implement createStudent() method.
    }

    /**
     * @param $student
     * @return mixed
     */
    public function getStudentById($student)
    {
        // TODO: Implement getStudentById() method.
    }

    /**
     * @param array $request
     * @param $student
     * @return mixed
     */
    public function updateStudent(array $request, $student)
    {
        // TODO: Implement updateStudent() method.
    }

    /**
     * @param $student
     * @return mixed
     */
    public function forceDeleteStudent($student)
    {
        // TODO: Implement forceDeleteStudent() method.
    }
}
