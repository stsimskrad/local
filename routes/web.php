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
    Route::middleware(['auth','role:Super Administrator,Scholarship Coordinator,Scholar'])->group(function () {
        Route::prefix('user')->group(function(){
            Route::controller(App\Http\Controllers\UserController::class)->group(function () {
                Route::get('/logs', 'logs');
            });
        });
    });

    Route::middleware(['auth','role:Super Administrator'])->group(function () {
        Route::prefix('user')->group(function(){
            Route::controller(App\Http\Controllers\UserController::class)->group(function () {
                Route::get('/lists/{key}/{counts}', 'lists');
                Route::post('/password', 'password');
                Route::post('/store', 'store');
                Route::post('/verify', 'verify');
            });
        });

        Route::prefix('school')->group(function(){
            Route::controller(App\Http\Controllers\SchoolController::class)->group(function () {
                Route::get('/lists/{key}/{count}', 'lists');
                Route::get('/view/{id}', 'view');
                Route::post('/course/store', 'course');
                Route::post('/semester/store', 'semester');
                Route::get('/semester/{id}/{year}', 'semesteryear');
            });
        });

        Route::prefix('prospectus')->group(function(){
            Route::controller(App\Http\Controllers\Scholarship\Evaluation\ProspectusController::class)->group(function () {
                Route::get('/{school}/{course}/{count}/{keyword}', 'index');
                Route::get('/{id}', 'view');
                Route::post('/store', 'store');
                Route::get('/select/{id}', 'select');
            });
        });

        Route::prefix('download')->group(function(){
            Route::controller(App\Http\Controllers\DownloadController::class)->group(function () {
                Route::get('/info', 'index');
            });
        });

        Route::prefix('search')->group(function(){
            Route::controller(App\Http\Controllers\ListController::class)->group(function () {
                Route::post('/schools', 'schools');
                Route::post('/courses', 'courses');
                Route::post('/scholars', 'scholars');
            });
        });
    });


    Route::middleware(['auth','role:Scholarship Coordinator,Scholarship Staff'])->group(function () {
        Route::prefix('qualifier')->group(function(){
            Route::controller(App\Http\Controllers\Qualifier\IndexController::class)->group(function () {
                Route::get('{count}/{category}/{year}/{keyword}', 'index');
            });
        });

        Route::prefix('scholar')->group(function(){
            Route::controller(App\Http\Controllers\Scholarship\IndexController::class)->group(function () {
                Route::get('/{info}/{education}/{location}', 'lists');
                Route::post('/store', 'store');
                Route::get('/{id}', 'view');
                Route::get('/search/{keyword}', 'search');
                Route::get('/filter/{info}', 'filter');
                // Route::get('filter/{status}/{school}/{year}/{level}/{key}', 'filter');
            });

            Route::prefix('reports')->group(function(){
                Route::controller(App\Http\Controllers\Scholarship\ReportController::class)->group(function () {
                    Route::get('/category', 'category');
                    Route::get('/status', 'status');
                    Route::get('/totals', 'totals');
                    Route::get('/dashboard', 'dashboard');
                    Route::get('/cats', 'cats');
                    Route::get('/scholars/generate/{array}', 'scholars');
                });
            });

            Route::prefix('tracer')->group(function(){
                Route::controller(App\Http\Controllers\Scholarship\TraceController::class)->group(function () {
                    Route::post('/store', 'store');
                    Route::get('/{type}/{id}/{count}', 'index');
                });
            });
        });

        Route::prefix('evaluation')->group(function(){
            Route::prefix('enrollment')->group(function(){
                Route::controller(App\Http\Controllers\Scholarship\Evaluation\EnrollmentController::class)->group(function () {
                    Route::get('/search/{key}', 'search');
                    Route::post('/store', 'store');
                    Route::get('/lists/{id}', 'lists');
                    Route::get('/prospectus/{key}', 'prospectus');
                    Route::post('/switch', 'switch');
                    Route::get('/{id}/{keyword}', 'index');
                });
                Route::controller(App\Http\Controllers\Scholarship\Evaluation\ReportController::class)->group(function () {
                    Route::get('/reports', 'reports');
                });
            });

            Route::prefix('grading')->group(function(){
                Route::controller(App\Http\Controllers\Scholarship\Evaluation\GradeController::class)->group(function () {
                    Route::post('/store', 'store');
                });
            });

            Route::prefix('prospectus')->group(function(){
                Route::controller(App\Http\Controllers\Scholarship\Evaluation\ProspectusController::class)->group(function () {
                    Route::get('/{school}/{course}/{count}/{keyword}', 'index');
                    Route::get('/{id}', 'view');
                    Route::post('/store', 'store');
                    Route::get('/select/{id}', 'select');
                });
            });
        });

        Route::prefix('benefit')->group(function(){
            Route::controller(App\Http\Controllers\Scholarship\Benefit\GroupController::class)->group(function () {
                Route::get('/group/latest', 'latest');
                Route::get('/generate/{array}', 'benefits');
                Route::post('/store', 'store');
                Route::post('/storegroup', 'storegroup');
                Route::get('/lists/{key}', 'lists');
                Route::get('/view/{id}', 'view');
            });
            Route::controller(App\Http\Controllers\Scholarship\Benefit\IndexController::class)->group(function () {
                // Route::post('/store', 'store');
                // Route::get('/{id}/{counts}', 'index');
                // Route::get('/stipend/x/{id}', 'stipend');
                // Route::get('/breakdown/x/{id}', 'breakdown');
                // Route::get('/{keyword}/{year}/{count}', 'lists');
                // Route::get('/{array}', 'profile');
            });
        });

        Route::prefix('school')->group(function(){
            Route::controller(App\Http\Controllers\SchoolController::class)->group(function () {
                Route::get('/semester/{id}/{year}', 'semesteryear');
                Route::get('/subcourses/{school}/{course}', 'subcourses');
            });
        });

        Route::prefix('accounting')->group(function(){
            Route::prefix('allotment')->group(function(){
                Route::controller(App\Http\Controllers\Accounting\AllotmentController::class)->group(function () {
                    Route::post('/store', 'store');
                    Route::get('/{key}/{counts}', 'index');
                    Route::get('/{id}', 'view');
                    Route::post('/list/store', 'storeList');
                });
            });

            Route::prefix('disbursement')->group(function(){
                Route::controller(App\Http\Controllers\Accounting\DisbursementController::class)->group(function () {  
                    Route::post('/store', 'store');
                    Route::get('/{key}/{counts}', 'index');
                });
            });
        });

    });

    Route::middleware(['auth','role:Scholar'])->group(function () {
        Route::prefix('info')->group(function(){
            Route::controller(App\Http\Controllers\Scholar\ProfileController::class)->group(function () {
                Route::get('/', 'index');
            });
        });
    });

});

Route::prefix('excel')->group(function(){
    Route::post('/qualifier/import', [App\Http\Controllers\Qualifier\ImportController::class, 'index']);
    Route::post('/qualifier/store', [App\Http\Controllers\Qualifier\ImportController::class, 'store']);

    Route::post('/scholar/import', [App\Http\Controllers\Scholarship\ImportController::class, 'index']);
    Route::post('/scholar/store', [App\Http\Controllers\Scholarship\ImportController::class, 'store']);
});


Route::prefix('lists')->group(function(){
    Route::get('/', [App\Http\Controllers\ListController::class, 'index']);
    Route::get('/logs/{key}/{count}', [App\Http\Controllers\HomeController::class, 'logs']);

    Route::controller(App\Http\Controllers\ListController::class)->group(function () {
        Route::get('/','index');
        Route::get('/provinces/{code}', 'provinces');
        Route::get('/municipalities/{code}', 'municipalities');
        Route::get('/barangays/{code}', 'barangays');

        Route::prefix('search')->group(function(){
            Route::post('/schools', 'schools');
            Route::post('/courses', 'courses');
            // Route::post('/scholars', 'Lists\SearchController@scholars');
        });
    });
});

Route::prefix('sync')->group(function(){
    Route::get('/addresses/{type}/{category}', [App\Http\Controllers\Sync\IndexController::class, 'addresses']);
    Route::get('/lists/{type}/{category}', [App\Http\Controllers\Sync\IndexController::class, 'lists']);
    Route::get('/schools/{type}/{category}/{agency?}', [App\Http\Controllers\Sync\IndexController::class, 'schools']);
    // Route::get('/logs/{key}/{count}', [App\Http\Controllers\HomeController::class, 'logs']);
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '[\/\w\.-]*');