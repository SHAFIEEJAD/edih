<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/control-panel/users', function () {
    return inertia('admin/user/index');
});
Route::get('/control-panel/user/create', function () {
    return inertia('admin/user/create');
});
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
