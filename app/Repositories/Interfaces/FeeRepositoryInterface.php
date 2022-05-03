<?php

namespace App\Repositories\Interfaces;

interface FeeRepositoryInterface
{
    public function getAllFees();
    public function createFee(array $request);
    public function getFeeById($fee);
    public function updateFee(array $request, $fee);
    public function forceDeleteFee($fee);
}
