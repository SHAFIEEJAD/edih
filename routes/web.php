<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TestManagementController;
use App\Http\Controllers\QuizzController;

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
Route::post('dashboard/logout', [LoginController::class, 'destroy'])->name('logout');

// Guest Route for end-users
Route::get('/', [QuizzController::class, 'index'])->middleware('guest')->name('quiz'); 
Route::post('/store', [QuizzController::class, 'store'])->middleware('guest'); 

// Protected Routes
Route::middleware('auth')->prefix('/dashboard')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management Routes
    Route::get('/users', [AdminController::class, 'index'])->name('user.index');
    Route::get('/user/create', [AdminController::class, 'create']);
    Route::post('/user/store', [AdminController::class, 'store']);
    Route::get('/user/{user}/edit', [AdminController::class, 'edit']);
    Route::post('/user/{user}/update', [AdminController::class, 'update']);
    Route::get('/user/{user}/activate', [AdminController::class, 'activate']);
    Route::delete('/user/{user}', [AdminController::class, 'destroy']);

    // Test Management Routes
    Route::get('/tests', [TestManagementController::class, 'index'])->name('test.index');
    Route::get('/test/create', [TestManagementController::class, 'create']);
    Route::post('/test/store', [TestManagementController::class, 'store']);
    Route::get('/test/{test}/edit', [TestManagementController::class, 'edit']);
    Route::post('/test/{test}/update', [TestManagementController::class, 'update']);
    Route::get('/test/{test}/activate', [TestManagementController::class, 'activate']);
    Route::delete('/test/{test}', [TestManagementController::class, 'destroy']);

    // Email Management Routes
    Route::get('/emails', [EmailController::class, 'index'])->name('email.index');
    Route::get('/email/create', [EmailController::class, 'create']);
    Route::post('/email/store', [EmailController::class, 'store']);
    Route::get('/email/{email}/edit', [EmailController::class, 'edit']);
    Route::post('/email/{email}/update', [EmailController::class, 'update']);
    Route::get('/email/{email}/activate', [EmailController::class, 'activate']);
    Route::delete('/email/{email}', [EmailController::class, 'destroy']);
    Route::put('/email/{email}/test/{test}', [EmailController::class, 'changeTest']);
 
    // Department Management Routes
    Route::get('/departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create']);
    Route::post('/department/store', [DepartmentController::class, 'store']);
    Route::post('/department/{department}/update', [DepartmentController::class, 'update']);
    Route::delete('/department/{department}', [DepartmentController::class, 'destroy']);

});

