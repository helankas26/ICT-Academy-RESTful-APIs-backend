<?php

use App\Http\Controllers\Reporting\AdvanceReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('AdvanceReporting')
    ->as('advanceReports.')
    ->group(function (){
        Route::get('/advances', [AdvanceReportController::class, 'index'])->name('index');
        Route::get('/advances/byEmployee', [AdvanceReportController::class, 'indexByEmployeeType'])->name('index.byEmployee');
        Route::get('/employees/{employee:employeeID}/advances', [AdvanceReportController::class, 'showByEmployee'])->name('show.employee');
    });
