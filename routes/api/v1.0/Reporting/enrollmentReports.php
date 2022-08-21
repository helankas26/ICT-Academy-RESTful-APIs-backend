<?php

use App\Http\Controllers\Reporting\EnrollmentReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('EnrollmentReporting')
    ->as('enrollmentReports.')
    ->group(function (){
        Route::get('/classes/{class:classID}/enrollments', [EnrollmentReportController::class, 'index'])->name('index');
    });
