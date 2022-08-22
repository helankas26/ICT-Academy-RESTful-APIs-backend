<?php

use App\Http\Controllers\Reporting\AttendanceReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('AttendanceReporting')
    ->as('attendanceReports.')
    ->group(function (){
        Route::get('/classes/{class:classID}/advances/daily', [AttendanceReportController::class, 'showByDate'])->name('show.daily');
        Route::get('/classes/{class:classID}/advances/monthly', [AttendanceReportController::class, 'showByMonth'])->name('show.monthly');
    });
