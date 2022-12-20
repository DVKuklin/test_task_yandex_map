<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::name('page.')->controller(PageController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/register', 'register')->name('register');
    Route::get('/login', 'login')->name('login');
});

Route::name('auth.')->prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');;
    Route::post('/logout', 'logout')->name('logout');;
});