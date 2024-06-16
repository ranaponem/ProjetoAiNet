<?php

use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\UserController;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;

//Not verified users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});

//Verified users
Route::middleware('auth', 'verified')->group(function () {
        Route::view('/dashboard', 'dashboard')->name('dashboard');
        Route::resource('customers', CustomerController::class);
        Route::resource('screenings',ScreeningController::class);
        Route::resource('users', UserController::class);
        Route::resource('theaters', TheaterController::class);
        Route::delete('theaters/{theater}/photo', [TheaterController::class, 'destroyPhoto'])->name('theaters.photo.destroy')->can('update', 'theater');
        Route::delete('users/{user}/photo', [UserController::class, 'destroyPhoto'])
            ->name('users.photo.destroy')
            ->middleware('can:destroyPhoto,user');

        Route::resource('movies', MovieController::class)->except(['index, show']);
        Route::get('/movies', [MovieController::class, 'index'])->name('movies.index')->can('viewAny', Movie::class);
});

//Public routes

Route::get('/', function () {
    return redirect()->route('movies.indexOnShow');
})->name('home');

Route::get('/moviesOnShow', [MovieController::class, 'indexOnShow'])->name('movies.indexOnShow');
Route::get('/moviesOnShow/{movie}/show', [MovieController::class, 'show'])->name('movies.show');

Route::middleware('can:use-cart')->group(function () {
    // Add a discipline to the cart:
    Route::post('cart/{ticket}', [CartController::class, 'addToCart'])
        ->name('cart.add');
    // Remove a discipline from the cart:
    Route::delete('cart/{ticket}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});

require __DIR__.'/auth.php';
