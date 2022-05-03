<?php

namespace App\Repositories\Interfaces;

interface ExpenditureRepositoryInterface
{
    public function getAllExpenditures();
    public function createExpenditure(array $request);
    public function getExpenditureById($expenditure);
    public function updateExpenditure(array $request, $expenditure);
    public function forceDeleteExpenditure($expenditure);
}
