<?php

use App\Http\Controllers\Reporting\ExamMarksReportController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('ExamMarksReporting')
    ->as('examMarksReports.')
    ->group(function (){
        Route::get('/exams/{exam:examID}/marks', [ExamMarksReportController::class, 'show'])->name('show');
    });
