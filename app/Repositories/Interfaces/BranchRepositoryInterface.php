<?php

namespace App\Repositories\Interfaces;

interface BranchRepositoryInterface
{
    public function getAllBranches();
    public function createBranch(array $request);
    public function getBranchById($branch);
    public function updateBranch(array $request, $branch);
    public function forceDeleteBranch($branch);
}
