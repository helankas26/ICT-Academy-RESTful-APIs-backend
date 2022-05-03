<?php

namespace App\Repositories\Interfaces;

interface AttendanceRepositoryInterface
{
    public function getAllAttendances();
    public function createAttendance(array $request);
    public function getAttendanceById($attendance);
    public function updateAttendance(array $request, $attendance);
    public function forceDeleteAttendance($attendance);
}
