<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // permission route
    Route::resource('permission',PermissionController::class);

    // roles route
    Route::resource('roles',RoleController::class);

    // articles route
    Route::resource('articles',ArticleController::class);

    // user route
    Route::resource('users',UserController::class);
    Route::get('add-to-role/{id}',[UserController::class,'addToRole'])->name('user.addToRole');
    Route::post('add-to-role-process/{id}',[UserController::class,'addToRoleProcess'])->name('user.addToRoleProcess');
});

require __DIR__.'/auth.php';
