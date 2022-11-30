<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if(Auth::user()){
        return redirect()->route('home');
    } else {
        return redirect()->route('backOffice');
    }
    return view('auth.login');
});


Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/getHours', [App\Http\Controllers\HomeController::class, 'getHours'])->name('getHours');
    Route::post('/makeAppointment', [App\Http\Controllers\HomeController::class, 'makeAppointment'])->name('makeAppointment');
    Route::get('/delete/{id}', [App\Http\Controllers\HomeController::class, 'deleteAppointment'])->name('deleteAppointment');
    Route::get('/backOffice', [App\Http\Controllers\BackOffice::class, 'index'])->name('backOffice');
});
