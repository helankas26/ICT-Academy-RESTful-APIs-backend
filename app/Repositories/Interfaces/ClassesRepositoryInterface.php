<?php

namespace App\Repositories\Interfaces;

interface ClassesRepositoryInterface
{
    public function getAllClasses();
    public function createClass(array $request);
    public function getClassById($class);
    public function updateClass(array $request, $class);
    public function forceDeleteClass($class);
}
