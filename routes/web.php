<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
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

// Unauthenticated Users
Route::get('/', [AuthenticateController::class, 'login']);
Route::post('/auth', [AuthenticateController::class, 'auth']);

Route::get('/users/create', [UsersController::class, 'create']);
Route::post('/users/create', [UsersController::class, 'store']);
// Authenticated Users
Route::middleware('auth')->group(function () {
    // Authenticated Users
    Route::get('/home', function () {
        return view('index');
    });
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/users/edit/{id}', [UsersController::class, 'edit']);
    Route::post('/users/update/{id}', [UsersController::class, 'update']);
    Route::get('/users/destroy/{id}', [UsersController::class, 'destroy']);
    Route::get('/logout', [AuthenticateController::class, 'logout']);

    //Book
    Route::get('/book', [BooksController::class, 'index']);
    Route::get('/create_book', [BooksController::class, 'create']);
    Route::post('/create_book', [BooksController::class, 'store']);
    Route::get('/edit_book/{id}', [BooksController::class, 'edit']);
    Route::post('/update_book/{id}', [BooksController::class, 'update']);
    Route::get('delete_book/{id}', [BooksController::class, 'destroy']);

    //Author
    Route::get('/author', [AuthorController::class, 'index']);
    Route::get('/create_author', [AuthorController::class, 'create']);
    Route::post('/create_author', [AuthorController::class, 'store']);
    Route::get('/edit_author/{id}', [AuthorController::class, 'edit']);
    Route::post('/update_author/{id}', [AuthorController::class, 'update']);
    Route::get('/delete_author/{id}', [AuthorController::class, 'destroy']);

    //Category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/create_category', [CategoryController::class, 'create']);
    Route::post('/create_category', [CategoryController::class, 'store']);
    Route::get('/edit_category/{id}', [CategoryController::class, 'edit']);
    Route::post('/update_category/{id}', [CategoryController::class, 'update']);
    Route::get('/delete_category/{id}', [CategoryController::class, 'destroy']);
});
