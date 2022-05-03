<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\ExpenditureRepositoryInterface;

class ExpenditureRepository implements ExpenditureRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getAllExpenditures()
    {
        // TODO: Implement getAllExpenditures() method.
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createExpenditure(array $request)
    {
        // TODO: Implement createExpenditure() method.
    }

    /**
     * @param $expenditure
     * @return mixed
     */
    public function getExpenditureById($expenditure)
    {
        // TODO: Implement getExpenditureById() method.
    }

    /**
     * @param array $request
     * @param $expenditure
     * @return mixed
     */
    public function updateExpenditure(array $request, $expenditure)
    {
        // TODO: Implement updateExpenditure() method.
    }

    /**
     * @param $expenditure
     * @return mixed
     */
    public function forceDeleteExpenditure($expenditure)
    {
        // TODO: Implement forceDeleteExpenditure() method.
    }
}
