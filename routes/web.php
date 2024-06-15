<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdsController;
use App\Http\Middleware\Localize;

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

/*Route::controller(UserController::class)->group(function () {
    Route::get('/showusers', 'index');
 //   Route::post('/store_user', 'store');
 //   Route::get('/user/show/{id}', 'show');
 //   Route::post('/user/update/{id}', 'update');
 //   Route::delete('/user/delete/{id}', 'destroy');
});*/
//->prefix('{local}')
Route::middleware(Localize::class)->group(function(){
    Route::resource('users',UserController::class);
});



Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/user/update/{id}', 'update');
});
Route::controller(AdsController::class)->group(function () {
    Route::get('/ads/get', 'index');
    Route::delete('/ads/delete/{id}', 'destroy');
    Route::get('/ads/show/{id}', 'show');
    Route::post('/ads/store', 'store');
    Route::post('/ads/update/{id}', 'update');
});
