<?php

namespace App\Repositories\Implementation;

use App\Http\Requests\StoreExpenditureRequest;
use App\Http\Requests\UpdateExpenditureRequest;
use App\Models\Expenditure;
use App\Repositories\Interfaces\ExpenditureRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpenditureRepository implements ExpenditureRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function getAllExpenditures(Request $request)
    {
        if ($request->date != null) {
            $expenditures = Expenditure::query()->with(['staff', 'branch'])
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->orderBy('date', 'asc')
                ->get();

            if ($expenditures->isEmpty()) {
                throw new Exception('Failed to retrieve Expenditures');
            }

            return $expenditures;
        }

        $expenditures = Expenditure::query()->with(['staff', 'branch'])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->orderBy('date', 'asc')
            ->get();

        if ($expenditures->isEmpty()) {
            throw new Exception('Failed to retrieve Expenditures');
        }

        return $expenditures;
    }

    /**
     * @param StoreExpenditureRequest $request
     * @return mixed
     */
    public function createExpenditure(StoreExpenditureRequest $request)
    {
        return Expenditure::query()->create([
            'expense' => data_get($request, 'expense'),
            'expenseAmount' => data_get($request, 'expenseAmount'),
            'date' => data_get($request, 'date'),
            'handlerStaffID' => data_get($request, 'handlerStaffID'),
            'branchID' => data_get($request, 'branchID'),
        ]);
    }

    /**
     * @param Expenditure $expenditure
     * @return mixed
     */
    public function getExpenditureById(Expenditure $expenditure)
    {
        return Expenditure::query()->find($expenditure);
    }

    /**
     * @param UpdateExpenditureRequest $request
     * @param Expenditure $expenditure
     * @return mixed
     * @throws Exception
     */
    public function updateExpenditure(UpdateExpenditureRequest $request, Expenditure $expenditure)
    {
        $updated = $expenditure->update([
            'expense' => data_get($request, 'expense', $expenditure->expense),
            'expenseAmount' => data_get($request, 'expenseAmount', $expenditure->expenseAmount),
            'date' => data_get($request, 'date', $expenditure->date),
            'handlerStaffID' => data_get($request, 'handlerStaffID', $expenditure->handlerStaffID),
            'branchID' => data_get($request, 'branchID', $expenditure->branchID),
        ]);

        if (!$updated) {
            throw new Exception('Failed to update Expenditures: ' . $expenditure->expenseID);
        }

        return $expenditure;
    }

    /**
     * @param Expenditure $expenditure
     * @return mixed
     * @throws Exception
     */
    public function forceDeleteExpenditure(Expenditure $expenditure)
    {
        $deleted = $expenditure->delete();

        if (!$deleted){
            throw new Exception('Failed to delete Expenditures: ' . $expenditure->expenseID);
        }

        return $deleted;
    }
}
