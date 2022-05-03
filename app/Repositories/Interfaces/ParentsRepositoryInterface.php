<?php

namespace App\Repositories\Interfaces;

interface ParentsRepositoryInterface
{
    public function getAllParents();
    public function createParent(array $request);
    public function getParentById($parent);
    public function updateParent(array $request, $parent);
    public function forceDeleteParent($parent);
}
