<?php

use App\Http\Controllers\Reporting\ExpenseReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('ExpenseReporting')
    ->as('expenseReports.')
    ->group(function (){
        Route::get('/expenses', [ExpenseReportController::class, 'index'])->name('index');
        Route::get('/branches/{branch:branchID}/expenses', [ExpenseReportController::class, 'indexByBranch'])->name('index.byBranch');
    });
