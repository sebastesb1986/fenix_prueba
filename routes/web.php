<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class , 'login']);
Route::post('logout', [LoginController::class , 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group([

    'middleware' => 'auth',
    'prefix' => 'auth'

], function ($router) {

    // User
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::post('create', [UserController::class, 'store'])->name('user.store');
    Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('user.delete');

});
