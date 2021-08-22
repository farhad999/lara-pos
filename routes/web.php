<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
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


Route::middleware('guest')->group(function (){
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('login', [AuthController::class, 'loginPage'])->name('login');
});

Route::middleware('auth')->group(function (){
    Route::get('/', function () {
        return view('home.index');
    })->name('home');

    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //categories

    Route::resource('/categories', CategoryController::class);

    //brands

    Route::resource('/brands', BrandController::class);

});
