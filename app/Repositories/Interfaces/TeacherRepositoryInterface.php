<?php

namespace App\Repositories\Interfaces;

interface TeacherRepositoryInterface
{
    public function getAllTeachers();
    public function createTeacher(array $request);
    public function getTeacherById($teacher);
    public function updateTeacher(array $request, $teacher);
    public function forceDeleteTeacher($teacher);
}
