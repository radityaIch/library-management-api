<?php

use App\Http\Controllers\LendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
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

// member
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function () {
    // member
    Route::post('/login', [MemberController::class, 'login']);
    Route::post('/register', [MemberController::class, 'store']);
    Route::get('/logged_in', [MemberController::class, 'member'])->middleware('member');
    // Route::get('/user/profile', [MemberController::class, 'show'])->middleware('member');
    // Route::patch('/user/update', [MemberController::class, 'update'])->middleware('member');
    // Route::delete('/user/delete', [MemberController::class, 'destroy'])->middleware('member');
});

// admin
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    // member
    Route::get('/users', [MemberController::class, 'index'])->middleware('admin');
    Route::post('/user', [MemberController::class, 'store'])->middleware('admin');
    Route::get('/user/{id}', [MemberController::class, 'show'])->middleware('admin');
    Route::patch('/user/{id}', [MemberController::class, 'update'])->middleware('admin');
    Route::delete('/user/{id}', [MemberController::class, 'destroy'])->middleware('admin');


    // admin
    Route::post('/admin/login', [UserController::class, 'login']);
    Route::get('/admin/logout', [UserController::class, 'logout'])->middleware('admin');
    Route::get('/admin/logged_in', [UserController::class, 'user'])->middleware('admin');
    Route::get('/admin/users', [UserController::class, 'index'])->middleware('admin');
    Route::post('/admin/refresh', [UserController::class, 'refresh']);
    Route::get('/admin/user/{id}', [UserController::class, 'show'])->middleware('admin');
    Route::get('/admin/user/verify/{id}', [UserController::class, 'verified'])->middleware('admin');
    Route::post('/admin/user/update', [UserController::class, 'update'])->middleware('admin');
    Route::post('/admin/user/update/{id}', [UserController::class, 'updateById'])->middleware('admin');
    Route::get('/admin/user/delete/{id}', [UserController::class, 'destroy'])->middleware('admin');
    Route::post('/admin/user/register', [UserController::class, 'register'])->middleware('admin');
});


// book api
Route::group([
    'middleware' => 'api',
    'prefix' => 'books'
], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/book/{id}', [BookController::class, 'show']);
    Route::post('/book/', [BookController::class, 'store'])->middleware('admin');
    // Route::post('/book/{id}', [BookController::class, 'update'])->middleware('admin');
    Route::patch('/book/{id}', [BookController::class, 'update'])->middleware('admin')->middleware('put.form');
    Route::delete('/book/{id}', [BookController::class, 'destroy'])->middleware('admin');

    // categories
    Route::get('/categories/', [BookCategoryController::class, 'index']);
    Route::get('/category/{id}', [BookCategoryController::class, 'show']);
    Route::post('/category/', [BookCategoryController::class, 'store'])->middleware('admin');
    Route::patch('/category/{id}', [BookCategoryController::class, 'update'])->middleware('admin');
    Route::delete('/category/{id}', [BookCategoryController::class, 'destroy'])->middleware('admin');
});

// lend API
Route::group([
    'middleware' => 'api',
    'prefix' => 'lends'
], function () {
    Route::get('/', [LendController::class, 'index']);
    Route::get('/mylends', [LendController::class, 'showByMember'])->middleware('member');
    Route::post('/mylends', [LendController::class, 'store'])->middleware('member');

    Route::post('/lend/add', [LendController::class, 'storeAdmin'])->middleware('admin');
    Route::get('/lend/{id}', [LendController::class, 'show']);
    Route::post('/lend/{id}', [LendController::class, 'update'])->middleware('admin');
    Route::delete('/lend/{id}', [LendController::class, 'destroy'])->middleware('admin');
});
