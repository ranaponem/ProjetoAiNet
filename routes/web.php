<?php

use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\UserController;
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
        Route::resource('users', UserController::class);
        Route::resource('theaters', TheaterController::class);
});

//Public routes

Route::get('/', function () {
    return redirect()->route('movies.index');
})->name('home');

Route::resource('movies', MovieController::class);

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
