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


// book api
Route::group([
    'middleware' => 'api',
    'prefix' => 'books'
], function(){
    Route::get('/', [BookController::class, 'index']);
    Route::get('/book/{id}', [BookController::class, 'show']);
    Route::post('/book/', [BookController::class, 'store'])->middleware('admin');
    // Route::post('/book/{id}', [BookController::class, 'update'])->middleware('admin');
    Route::patch('/book/{id}', [BookController::class, 'update'])->middleware('admin')->middleware('put.form');
    Route::delete('/book/{id}', [BookController::class, 'destroy'])->middleware('admin');

    // categories
    Route::get('/categories/', [BookCategoryController::class, 'index']);
    Route::get('/category/{id}', [BookCategoryController::class, 'show'])->middleware('admin');
    Route::post('/category/', [BookCategoryController::class, 'store'])->middleware('admin');
    Route::patch('/category/{id}', [BookCategoryController::class, 'update'])->middleware('admin');
    Route::delete('/category/{id}', [BookCategoryController::class, 'destroy'])->middleware('admin');
});
