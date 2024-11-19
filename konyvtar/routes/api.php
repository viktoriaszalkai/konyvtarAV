<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Librarian;
use App\Http\Middleware\User;
use App\Http\Middleware\Warehouseman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//bárki által elérhető
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/books-copies', [BookController::class, "booksFilterByUser"]);

//autintikált felhasználó
Route::middleware(['auth:sanctum'])
    ->group(function () {
       
        //profil
        Route::apiResource('/auth-users', UserController::class)->except(['destroy']);

        Route::get('/lendings-copies', [LendingController::class, "lendingsFilterByUser"]);
        Route::get('/user-lendings', [UserController::class, 'userLendingsFilterByUser']);
        Route::patch('update-password/{id}', [UserController::class, 'updatePassword']);
        // Kijelentkezés útvonal
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    });
//admin réteg
Route::middleware(['auth:sanctum', Admin::class])
    ->group(function () {
        //Route::get('/admin/users', [UserController::class, 'index']);
        //összes kérés egy útvonalon
        Route::apiResource('/admin/users', UserController::class);
    });
//könyvtáros réteg  Librarian.php middlewarehoz tartozik
Route::middleware(['auth:sanctum', Librarian::class])
    ->group(function () {
       
    });
//raktáros réteg warehouseman.php middlewarehoz tartozik
Route::middleware(['auth:sanctum', Warehouseman::class])
    ->group(function () {
       Route::get('/warehouseman/copies/{title}',[CopyController::class, 'bookCopyCount']);
    });
//felhasználó réteg
Route::middleware(['auth:sanctum', User::class])
    ->group(function () {
        Route::get('/admin/users', [UserController::class, 'index']);
        //összes kérés egy útvonalon
        Route::apiResource('/users', UserController::class);
    });

    
//milyen könyvek vannak nálam
Route::get('/active-lendings-data',[LendingController::class,'activeLendingsData']);