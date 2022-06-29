<?php

use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('EnrollmentManagement')
    ->as('enrollments.')
    ->group(function (){
        Route::get('/students', [EnrollmentController::class, 'index'])->name('index');
        Route::get('/students/notInFreeCard', [EnrollmentController::class, 'indexNotInFreeCard'])->name('index.notInFreeCard');
        Route::get('/students/inFreeCard', [EnrollmentController::class, 'indexInFreeCard'])->name('index.inFreeCard');
        Route::get('/students/{student:studentID}', [EnrollmentController::class, 'show'])->name('show');
        Route::post('/students', [EnrollmentController::class, 'store'])->name('store');
        Route::patch('/students/{student:studentID}/classes/{class:classID}/freeClass', [EnrollmentController::class, 'update'])->name('update');
        Route::patch('/students/{student:studentID}/classes/{class:classID}', [EnrollmentController::class, 'updateStudentStatus'])->name('update.student.status');
        Route::patch('/students/{student:studentID}/classes', [EnrollmentController::class, 'updateStudentStatusForAll'])->name('update.student.statusForAll');
        Route::patch('/students/{student:studentID}/classes/{class:classID}/daily', [EnrollmentController::class, 'updateDailyPaid'])->name('update.dailyPaid');
        Route::patch('/students/{student:studentID}/monthly', [EnrollmentController::class, 'updateMonthlyPaid'])->name('update.monthlyPaid');
        Route::delete('/students/{student:studentID}', [EnrollmentController::class, 'destroy'])->name('destroy');

        Route::get('/classes', [EnrollmentController::class, 'indexClasses'])->name('index.classes');
        Route::get('/classes/{class:classID}', [EnrollmentController::class, 'showClass'])->name('show.class');
        Route::get('/classes/{class:classID}/notInClass', [EnrollmentController::class, 'showNotInClass'])->name('show.notInClass');
        Route::post('/classes', [EnrollmentController::class, 'storeClass'])->name('store.class');
        Route::patch('/classes/{class:classID}/students/{student:studentID}/daily', [EnrollmentController::class, 'updateDaily'])->name('update.daily');
        Route::patch('/classes/monthly', [EnrollmentController::class, 'updateMonthly'])->name('update.monthly');
        Route::patch('/classes/{class:classID}/students', [EnrollmentController::class, 'updateClassStatusForAll'])->name('update.class.statusForAll');
        Route::delete('/classes/{class:classID}', [EnrollmentController::class, 'destroyClass'])->name('destroy.class');
    });
