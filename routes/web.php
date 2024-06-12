<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Criar rotas para os diferentes tipos de utilizadores
//Miguel Silva
Route::middleware(['auth', 'can:admin'])->group(function () {
    //group of routes that are only accessible to users who are admins


    Route::middleware(['auth', 'can:employee'])->group(function () {
        //group of routes that are only accessible to users who are employees


    });
    Route::middleware(['auth', 'can:customer'])->group(function () {
        //group of routes that are only accessible to users who are customers


    });
});

require __DIR__.'/auth.php';
