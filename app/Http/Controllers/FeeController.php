<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeeCollection;
use App\Http\Resources\FeeResource;
use App\Models\Classes;
use App\Models\Fee;
use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Student;
use App\Repositories\Interfaces\FeeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * @var FeeRepositoryInterface
     */
    private FeeRepositoryInterface $feeRepository;

    /**
     * @param FeeRepositoryInterface $feeRepository
     */
    public function __construct(FeeRepositoryInterface $feeRepository)
    {
        $this->feeRepository = $feeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FeeCollection
     */
    public function index(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date_format:Y']
        ]);

        $fees = $this->feeRepository->getAllFees($request);

        return new FeeCollection($fees);
    }

    /**
     * Display a listing of the resource.
     *
     * @return FeeCollection
     */
    public function indexTrashed(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date_format:Y']
        ]);

        $fees = $this->feeRepository->getAllTrashedFees($request);

        return new FeeCollection($fees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFeeRequest $request
     * @param Student $student
     * @param Classes $class
     * @return FeeCollection
     */
    public function storeOne(StoreFeeRequest $request, Student $student, Classes $class)
    {
        $created = $this->feeRepository->payForOneClass($request, $student, $class);

        return new FeeCollection($created);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFeeRequest $request
     * @param Student $student
     * @return FeeCollection
     */
    public function storeMany(StoreFeeRequest $request, Student $student)
    {
        $created = $this->feeRepository->payForManyClasses($request, $student);

        return new FeeCollection($created);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $feeID
     * @return JsonResponse
     */
    public function restore($feeID)
    {
        $restored = $this->feeRepository->trashedRestore($feeID);

        return new JsonResponse([
            'success' => $restored,
            'status' => $restored ? 'restored' : 'Failed'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Fee $fee
     * @return FeeResource
     */
    public function show(Fee $fee)
    {
        $fee = $this->feeRepository->getFeeById($fee);

        return new FeeResource($fee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFeeRequest $request
     * @param Fee $fee
     * @return FeeResource
     */
    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        $updated = $this->feeRepository->updateFee($request, $fee);

        return new FeeResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fee $fee
     * @return JsonResponse
     */
    public function destroy(Fee $fee)
    {
        $deleted = $this->feeRepository->softDeleteFee($fee);

        return new JsonResponse([
            'success' => $deleted,
            'status' => 'soft_deleted',
            'data' => new FeeResource($fee)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $feeID
     * @return JsonResponse
     */
    public function destroyTrashed($feeID)
    {
        $deleted = $this->feeRepository->forceDeleteFee($feeID);

        return new JsonResponse([
            'success' => $deleted,
            'status' => $deleted ? 'permanently_deleted' : 'Failed'
        ]);
    }
}
