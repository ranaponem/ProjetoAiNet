<?php

use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Ticket;
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

        Route::middleware('can:view,\App\Model\User')->group(function(){
            Route::resource('users', UserController::class);
        });
        Route::middleware('can:viewAny,\App\Model\Theater')->group(function(){
            Route::resource('theaters', TheaterController::class);
            Route::delete('theaters/{theater}/photo', [TheaterController::class, 'destroyPhoto'])->name('theaters.photo.destroy');
        });
        Route::middleware('can:viewAny,\App\Model\Ticket')->group(function(){
            Route::resource('tickets',TicketController::class)->except(['create', 'show', 'validate']);
        });
        Route::middleware('can:validate,\App\Model\Ticket')->get('tickets/validate', [TicketController::class, 'validate'])->name('tickets.validate');
        Route::delete('users/{user}/photo', [UserController::class, 'destroyPhoto'])
            ->name('users.photo.destroy')
            ->middleware('can:destroyPhoto,user');

        Route::get('/configuration', [ConfigurationController::class, 'edit'])->name('configuration.edit');
        Route::patch('/configuration', [ConfigurationController::class, 'update'])->name('configuration.update');

        Route::middleware('can:viewAny,\App\Model\Movie')->group(function(){
            Route::resource('movies', MovieController::class)->except(['index', 'show']);
        });

        Route::resource('genres', GenreController::class);
        Route::resource('screenings', ScreeningController::class)->except(['show']);

    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index')->can('viewAny', Movie::class);
    Route::get('/movies/statistics', [MovieController::class, 'statistics'])->name('movies.statistics')->can('viewStatistics', Movie::class);
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::resource('purchases', PurchaseController::class);
});

//Public routes

Route::get('/', function () {
    return redirect()->route('movies.indexOnShow');
})->name('home');

Route::get('/moviesOnShow', [MovieController::class, 'indexOnShow'])->name('movies.indexOnShow');
Route::get('/moviesOnShow/{movie}/show', [MovieController::class, 'show'])->name('movies.show');
Route::get('tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::get('/screenings/{screening}/show', [ScreeningController::class, 'show'])->name('screenings.show');

Route::middleware('can:use-cart')->group(function () {
    Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');

    Route::delete('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

require __DIR__.'/auth.php';
