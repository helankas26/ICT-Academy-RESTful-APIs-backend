<?php

namespace App\Repositories\Interfaces;

interface EnrollmentRepositoryInterface
{
    public function getAllEnrollment();
    public function createEnrollment(array $request);
    public function getEnrollmentById($enrollment);
    public function updateEnrollment(array $request, $enrollment);
    public function forceDeleteEnrollment($enrollment);
}
