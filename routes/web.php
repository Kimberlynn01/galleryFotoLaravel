<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Guest
Route::middleware(['guest'])->group(function () {

    // Route Login
    Route::prefix('/login')->name('login.')->group(function() {
        Route::get('/', [AuthController::class, 'login'])->name('index');
        Route::post('/post', [AuthController::class, 'postlogin'])->name('post');
    });

    // Route Register
    Route::prefix('/register')->name('register.')->group(function() {
        Route::get('/', [AuthController::class, 'register'])->name('index');
        Route::post('/post', [AuthController::class, 'postregister'])->name('post');
    });


});

// Middleware
Route::middleware(['auth'])->group(function () {
    Route::prefix('/dashboard')->name('dashboard.')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
    Route::prefix('/profile')->name('profile.')->group(function() {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

// Role Member
Route::middleware(['auth', 'role:0'])->group(function () {

    // Route Album
    Route::prefix('/album')->name('album.')->group(function() {
        Route::get('/', [AlbumController::class, 'index'])->name('index');
        Route::get('/tambah', [AlbumController::class, 'form'])->name('form');
        Route::post('/album/post', [AlbumController::class, 'store'])->name('form.post');
        Route::put('/album/update/{id}', [AlbumController::class, 'update'])->name('form.update');
        Route::delete('/album/delete/{id}', [AlbumController::class, 'delete'])->name('delete');
    });

    // Route Foto
    Route::prefix('/foto')->name('foto.')->group(function () {
        Route::get('/', [FotoController::class, 'index'])->name('index');
        Route::get('/form', [FotoController::class, 'form'])->name('form');
        Route::post('/form/post', [FotoController::class, 'store'])->name('form.post');
        Route::put('/update/{id}', [FotoController::class , 'update'])->name('update');

        // Route Status
        Route::prefix('/status')->name('status.')->group(function() {
            Route::get('/', [StatusController::class, 'index'])->name('index');
        });
    });

});



Route::middleware(['auth', 'role:1'])->group(function () {
    // Route Status
    Route::prefix('/status')->name('status.')->group(function() {
        Route::get('/', [StatusController::class, 'index'])->name('index');
    });
});
