<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminResetPasswordController;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->group(function (){
    Route::get('/', function(){
        return view('admins.home');
    });
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'loginPost'])->name('admin.login.post');
    Route::get('/dashboard/{id}', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/forgot-password', [AdminResetPasswordController::class, 'forgotPassword'])->name('admin.forgot.password');
    Route::post('/forgot-password', [AdminResetPasswordController::class, 'forgotPasswordPost'])->name('admin.forgot.password.post');
    Route::put('/reset-password', [AdminResetPasswordController::class, 'resetPasswordPost'])->name('admin.reset.password.post');
    Route::get('/reset-password/{token}', [AdminResetPasswordController::class, 'resetPassword'])->name('admin.reset.password');
});
Route::prefix('')->group(function(){
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'registerPost'])->name('register.post');
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginPost'])->name('login.post');
    
    Route::get('/dashboard/{id}', [UserController::class, 'dashboard'])->name('dashboard');
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
    Route::get('/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPasswordPost'])->name('forgot.password.post');
    Route::put('/reset-password', [ResetPasswordController::class, 'resetPasswordPost'])->name('reset.password.post');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');
});

