<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

interface FeeRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFees(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllTrashedFees(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTodayFeesCollectionsummary(Request $request);

    /**
     * @param StoreFeeRequest $request
     * @param Student $student
     * @param Classes $class
     * @return mixed
     */
    public function payForOneClass(StoreFeeRequest $request, Student $student, Classes $class);

    /**
     * @param StoreFeeRequest $request
     * @param Student $student
     * @return mixed
     */
    public function payForManyClasses(StoreFeeRequest $request, Student $student);

    /**
     * @param $feeID
     * @return mixed
     */
    public function trashedRestore($feeID);

    /**
     * @param Fee $fee
     * @return mixed
     */
    public function getFeeById(Fee $fee);

    /**
     * @param UpdateFeeRequest $request
     * @param Fee $fee
     * @return mixed
     */
    public function updateFee(UpdateFeeRequest $request, Fee $fee);

    /**
     * @param Fee $fee
     * @return mixed
     */
    public function softDeleteFee(Fee $fee);

    /**
     * @param $feeID
     * @return mixed
     */
    public function forceDeleteFee($feeID);
}
