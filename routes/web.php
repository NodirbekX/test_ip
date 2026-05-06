<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// homepage → dashboard
Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/time', [TimeController::class, 'index'])->name('time.index');
Route::post('/time', [TimeController::class, 'store'])->name('time.store');

Route::middleware('check.ip')->group(function () {

    Route::get('/exam', [StudentController::class, 'index'])->name('student.exam');
    Route::post('/exam', [StudentController::class, 'submit'])->name('student.submit');
    Route::get('/result', [StudentController::class, 'result'])->name('student.result');

});

Route::get('/ips', [AdminController::class, 'ips'])->name('ips.index');
Route::post('/ips', [AdminController::class, 'storeIp'])->name('ips.store');
Route::delete('/ips/{id}', [AdminController::class, 'deleteIp'])->name('ips.delete');

// tests page separate
Route::resource('tests', AdminController::class)->names([
    'index' => 'tests.index',
    'create' => 'tests.create',
    'store' => 'tests.store',
    'show' => 'tests.show',
    'edit' => 'tests.edit',
    'update' => 'tests.update',
    'destroy' => 'tests.destroy',
]);
