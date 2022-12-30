<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCategoryController;
use App\Models\BookCategory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('admin/login', [UserController::class, 'login']);
    Route::get('admin/logout', [UserController::class, 'logout'])->middleware('admin');
    Route::get('admin/users', [UserController::class, 'index'])->middleware('admin');
    Route::post('admin/refresh', [UserController::class, 'refresh']);
    Route::get('admin/user', [UserController::class, 'user'])->middleware('admin');
    Route::get('admin/user/{id}', [UserController::class, 'show'])->middleware('admin');
    Route::get('admin/user/verify/{id}', [UserController::class, 'verified'])->middleware('admin');
    Route::post('admin/user/update', [UserController::class, 'update'])->middleware('admin');
    Route::post('admin/user/update/{id}', [UserController::class, 'updateById'])->middleware('admin');
    Route::get('admin/user/delete/{id}', [UserController::class, 'destroy'])->middleware('admin');
    Route::post('admin/user/register', [UserController::class, 'register'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'book'
], function(){
    Route::get('/', [BookController::class, 'index']);
    Route::post('/create', [BookController::class, 'store'])->middleware('admin');
});
