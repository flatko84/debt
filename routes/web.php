<?php

use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoanController::class, 'index'])->name('loans_index');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans_create');
Route::post('/loans/store', [LoanController::class, 'store'])->name('loans_store');

Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments_create');
Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments_store');