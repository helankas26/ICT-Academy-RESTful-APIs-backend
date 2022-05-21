<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenditureCollection;
use App\Http\Resources\ExpenditureResource;
use App\Models\Expenditure;
use App\Http\Requests\StoreExpenditureRequest;
use App\Http\Requests\UpdateExpenditureRequest;
use App\Repositories\Interfaces\ExpenditureRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    /**
     * @var ExpenditureRepositoryInterface
     */
    private ExpenditureRepositoryInterface $expenditureRepository;

    /**
     * @param ExpenditureRepositoryInterface $expenditureRepository
     */
    public function __construct(ExpenditureRepositoryInterface $expenditureRepository)
    {
        $this->expenditureRepository = $expenditureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ExpenditureCollection
     */
    public function index(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $expenditures = $this->expenditureRepository->getAllExpenditures($request);

        return new ExpenditureCollection($expenditures);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExpenditureRequest $request
     * @return ExpenditureResource
     */
    public function store(StoreExpenditureRequest $request)
    {
        $created = $this->expenditureRepository->createExpenditure($request);

        return new ExpenditureResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param Expenditure $expenditure
     * @return ExpenditureCollection
     */
    public function show(Expenditure $expenditure)
    {
        $expenditure = $this->expenditureRepository->getExpenditureById($expenditure);

        return new ExpenditureCollection($expenditure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExpenditureRequest $request
     * @param Expenditure $expenditure
     * @return ExpenditureResource
     */
    public function update(UpdateExpenditureRequest $request, Expenditure $expenditure)
    {
        $updated = $this->expenditureRepository->updateExpenditure($request, $expenditure);

        return new ExpenditureResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Expenditure $expenditure
     * @return JsonResponse
     */
    public function destroy(Expenditure $expenditure)
    {
        $deleted = $this->expenditureRepository->forceDeleteExpenditure($expenditure);

        return new JsonResponse([
            'success' => $deleted,
            'status' => 'deleted',
            'data' => new ExpenditureResource($expenditure),
        ]);
    }
}
