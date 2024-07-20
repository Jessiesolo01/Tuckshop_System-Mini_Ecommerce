<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminResetPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;

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
    
    Route::get('/add-item', [ItemController::class, 'addItem'])->name('admin.addItem');
    Route::post('/add-item', [ItemController::class, 'addItemPost'])->name('admin.addItem.post');
    Route::get('/edit-item/{id}', [ItemController::class, 'editItem'])->name('admin.editItem');
    Route::put('/update-item/{id}', [ItemController::class, 'updateItem'])->name('admin.updateItem');
    Route::get('/items', [ItemController::class, 'showItem'])->name('admin.showItem');
    Route::delete('/delete-item/{id}', [ItemController::class, 'deleteItem'])->name('admin.deleteItem');

    Route::get('/add-user', [UserController::class, 'addUser'])->name('admin.addUser');
    Route::post('/add-user', [UserController::class, 'addUserPost'])->name('admin.addUser.post');
    Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('admin.editUser');
    Route::put('/update-user/{id}', [UserController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/users-list', [UserController::class, 'showUser'])->name('admin.showUser');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('admin.deleteUser');

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

