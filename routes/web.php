<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
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
    Route::post('/store_user', 'store');
    Route::get('/user/show/{id}', 'show');
    Route::post('/user/update/{id}', 'update');
    Route::delete('/user/delete/{id}', 'destroy');
});*/
//Route::middleware(Localize::class)->prefix('{local}')->group(function(){
    Route::resource('users',UserController::class);
    Route::controller(UserController::class)->group(function () {
        Route::post('/user/update/{id}', 'update');
    });

//});



Route::get('/', function () {
    return view('welcome');
});
