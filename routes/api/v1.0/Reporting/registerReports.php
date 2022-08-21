<?php

use App\Http\Controllers\Reporting\RegisterReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('RegisterReporting')
    ->as('registerReports.')
    ->group(function (){
        Route::get('/classes/{class:classID}/enrollments', [RegisterReportController::class, 'index'])->name('index');
    });
