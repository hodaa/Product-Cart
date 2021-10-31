<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\PaypalController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/paywithpaypal', [PaypalController::class,'payWithPaypal'])->name('paywithpaypal');
Route::post('/paypal', [PaypalController::class,'postPaymentWithPaypal'])->name('paypal');
Route::get('/paypal', [PaypalController::class,'getPaymentStatus'])->name('status');


Route::get('contact', [\App\Http\Controllers\ContactsController::class,'showContactForm']);
Route::post('contact', [\App\Http\Controllers\ContactsController::class,'contact']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
