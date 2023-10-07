<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TestManagementController;

use Inertia\Inertia;

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

Route::inertia('login', 'Auth/Login')->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.post');
Route::post('control-panel/logout', [LoginController::class, 'destroy'])->name('logout');

// Protected Routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {

        // if (auth()->check()) {
        //     dd(auth()->user());
        // }

        return inertia('create');
    });
    Route::get('/control-panel', function () {

        // if (auth()->check()) {
        //     dd(auth()->user());
        // }

        return inertia('create');
    });


    // User Management Routes
    Route::get('/control-panel/users', [AdminController::class, 'index'])->name('user.index');
    Route::get('/control-panel/user/create', [AdminController::class, 'create']);
    Route::post('/control-panel/user/store', [AdminController::class, 'store']);
    Route::get('/control-panel/user/{user}/edit', [AdminController::class, 'edit']);
    Route::post('/control-panel/user/{user}/update', [AdminController::class, 'update']);
    Route::get('/control-panel/user/{user}/activate', [AdminController::class, 'activate']);
    Route::delete('/control-panel/user/{user}', [AdminController::class, 'destroy']);

    // Test Management Routes
    Route::get('/control-panel/tests', [TestManagementController::class, 'index'])->name('test.index');
    Route::get('/control-panel/test/create', [TestManagementController::class, 'create']);
    Route::post('/control-panel/test/store', [TestManagementController::class, 'store']);
    Route::get('/control-panel/test/{test}/edit', [TestManagementController::class, 'edit']);
    Route::post('/control-panel/test/{test}/update', [TestManagementController::class, 'update']);
    Route::get('/control-panel/test/{test}/activate', [TestManagementController::class, 'activate']);
    Route::delete('/control-panel/test/{test}', [TestManagementController::class, 'destroy']);

    // Email Management Routes
    Route::get('/control-panel/emails', [EmailController::class, 'index'])->name('email.index');
    Route::get('/control-panel/email/create', [EmailController::class, 'create']);
    Route::post('/control-panel/email/store', [EmailController::class, 'store']);
    Route::get('/control-panel/email/{email}/edit', [EmailController::class, 'edit']);
    Route::post('/control-panel/email/{email}/update', [EmailController::class, 'update']);
    Route::get('/control-panel/email/{email}/activate', [EmailController::class, 'activate']);
    Route::delete('/control-panel/email/{email}', [EmailController::class, 'destroy']);
    Route::put('/control-panel/email/{email}/test/{test}', [EmailController::class, 'changeTest']);
 
});

