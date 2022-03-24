<?php

use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\WelcomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [WelcomeController::class, 'savePassword']);
});

Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Web Requests
|--------------------------------------------------------------------------
*/

Route::prefix('request')->group(function(){

    Route::middleware(['auth','role:Super Administrator'])->group(function () {
        Route::prefix('user')->group(function(){
            Route::controller(App\Http\Controllers\UserController::class)->group(function () {
                Route::get('/lists/{key}/{counts}', 'lists');
                Route::get('/logs', 'logs');
                Route::post('/password', 'password');
                Route::post('/store', 'store');
                Route::post('/verify', 'verify');
            });
        });
    });

});

Route::prefix('lists')->group(function(){
    Route::get('/', [App\Http\Controllers\ListController::class, 'index']);
    Route::get('/logs/{key}/{count}', [App\Http\Controllers\HomeController::class, 'logs']);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '[\/\w\.-]*');