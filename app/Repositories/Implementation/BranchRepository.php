<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\BranchRepositoryInterface;

class BranchRepository implements BranchRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllBranches()
    {
        // TODO: Implement getAllBranches() method.
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createBranch(array $request)
    {
        // TODO: Implement createBranch() method.
    }

    /**
     * @param $branch
     * @return mixed
     */
    public function getBranchById($branch)
    {
        // TODO: Implement getBranchById() method.
    }

    /**
     * @param array $request
     * @param $branch
     * @return mixed
     */
    public function updateBranch(array $request, $branch)
    {
        // TODO: Implement updateBranch() method.
    }

    /**
     * @param $branch
     * @return mixed
     */
    public function forceDeleteBranch($branch)
    {
        // TODO: Implement forceDeleteBranch() method.
    }
}
