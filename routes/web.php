<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return inertia('create');
});
Route::get('/control-panel', function () {
    return inertia('admin/index');
});

// Route::get('/control-panel/user/add', function () {
//     return inertia('admin/user/add');
// });
Route::get('/control-panel/users', [AdminController::class, 'index'])->name('user.index');
Route::get('/control-panel/user/create', [AdminController::class, 'create']);
Route::post('/control-panel/user/store', [AdminController::class, 'store']);
Route::get('/control-panel/user/{user}/edit', [AdminController::class, 'edit']);
Route::get('/control-panel/user/{user}/activate', [AdminController::class, 'activate']);
Route::delete('/control-panel/user/{user}', [AdminController::class, 'destroy']);
// Route::get('/', function () {
//     return inertia('create');
// });
// Route::get('/', function () {
//     return inertia('create');
// });
// Route::get('/', function () {
//     return inertia('create');
// });
// Route::get('/', function () {
//     return inertia('create');
// });
