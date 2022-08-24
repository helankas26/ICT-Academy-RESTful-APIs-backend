<?php

use App\Http\Controllers\Reporting\FinancialReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('FinancialReporting')
    ->as('financialReports.')
    ->group(function (){
        //Route::get('/fees/bill', [FinancialReportController::class, 'index'])->name('index');
        Route::get('/financials/daily', [FinancialReportController::class, 'indexDaily'])->name('daily');
        Route::get('/financials/monthly', [FinancialReportController::class, 'indexMonthly'])->name('monthly');
        Route::get('/financials/yearly', [FinancialReportController::class, 'indexYearly'])->name('yearly');
        Route::get('/staffs/{staff:staffID}/paySheet', [FinancialReportController::class, 'showStaffPaySheet'])->name('staffs.paySheet');
        Route::get('/teachers/{teacher:teacherID}/forDaily', [FinancialReportController::class, 'showTeacherPaySheetForDaily'])->name('teachers.paySheetForDaily');
        Route::get('/teachers/{teacher:teacherID}/forMonthly', [FinancialReportController::class, 'showTeacherPaySheetForMonthly'])->name('teachers.paySheetForMonthly');
        Route::get('/teachers/{teacher:teacherID}/targetSheet', [FinancialReportController::class, 'showTeacherTargetSheet'])->name('teachers.targetSheet');
    });
