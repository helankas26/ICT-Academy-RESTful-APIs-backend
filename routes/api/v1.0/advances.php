<?php

use App\Http\Controllers\AdvanceController;
use Illuminate\Support\Facades\Route;

Route::middleware([

])
    ->prefix('AdvanceManagement')
    ->as('advances.')
    ->group(function (){
        Route::get('/advances', [AdvanceController::class, 'index'])->name('index');
        Route::get('/advances/{advance:advanceID}', [AdvanceController::class, 'show'])->name('show');
        Route::post('/advances', [AdvanceController::class, 'store'])->name('store');
        Route::patch('/advances/{advance:advanceID}', [AdvanceController::class, 'update'])->name('update');
        Route::delete('/advances/{advance:advanceID}', [AdvanceController::class, 'destroy'])->name('destroy');
    });
