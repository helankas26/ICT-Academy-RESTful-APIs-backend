<?php

use App\Http\Controllers\Reporting\TimetableReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('TimetableReporting')
    ->as('timetableReports.')
    ->group(function (){
        Route::get('/teachers/classes', [TimetableReportController::class, 'index'])->name('index');
        Route::get('/branches/{branch:branchID}/classes', [TimetableReportController::class, 'indexByBranch'])->name('index.byBranch');
        Route::get('/teachers/classes/byDay', [TimetableReportController::class, 'indexByDay'])->name('index.byDay');
    });
