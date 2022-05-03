<?php

namespace App\Repositories\Interfaces;

interface StaffRepositoryInterface
{
    public function getAllStaffs();
    public function createStaff(array $request);
    public function getStaffById($staff);
    public function updateStaff(array $request, $staff);
    public function forceDeleteStaff($staff);
}
