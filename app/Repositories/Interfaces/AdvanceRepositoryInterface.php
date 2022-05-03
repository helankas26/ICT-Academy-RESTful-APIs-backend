<?php

namespace App\Repositories\Interfaces;

interface AdvanceRepositoryInterface
{
    public function getAllAdvances();
    public function createAdvance(array $request);
    public function getAdvanceById($advance);
    public function updateAdvance(array $request, $advance);
    public function forceDeleteAdvance($advance);
}
