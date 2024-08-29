<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AdminWalletController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminResetPasswordController;

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
    Route::get('/search-item', [ItemController::class, 'searchItem'])->name('admin.search.item');
    Route::delete('/delete-item/{id}', [ItemController::class, 'deleteItem'])->name('admin.deleteItem');

    Route::get('/add-user', [UserController::class, 'addUser'])->name('admin.addUser');
    Route::post('/add-user', [UserController::class, 'addUserPost'])->name('admin.addUser.post');
    Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('admin.editUser');
    Route::put('/update-user/{id}', [UserController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/search-user', [UserController::class, 'searchUser'])->name('admin.search.user');
    Route::get('/users-list', [UserController::class, 'showUser'])->name('admin.showUser');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::get('/view-receipt/{receipt_id}', [AdminWalletController::class, 'viewReceipt'])->name('admin.view.receipt');
    Route::get('/search-receipt', [AdminWalletController::class, 'searchReceipt'])->name('admin.search.receipt');

    Route::get('/retrieve-receipts', [AdminWalletController::class, 'retrieveReceipts'])->name('admin.retrieve.receipts');
    Route::delete('/cancel-receipt/{receipt_id}', [AdminWalletController::class, 'cancelReceipt'])->name('admin.cancel.receipt');
    Route::post('/confirm-receipt/{receipt_id}', [AdminWalletController::class, 'confirmReceipt'])->name('admin.confirm.receipt');

    Route::get('/retrieve-orders', [AdminOrderController::class, 'retrieveOrders'])->name('admin.retrieve.orders');
    Route::get('/search-order', [AdminOrderController::class, 'searchOrder'])->name('admin.search.order');
    Route::delete('/cancel-order/{order_id}', [AdminOrderController::class, 'cancelOrder'])->name('admin.cancel.order');
    Route::post('/confirm-delivery/{order_id}', [AdminOrderController::class, 'confirmDelivery'])->name('admin.confirm.delivery');
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

    Route::post('/create-order/{id}', [OrderController::class, 'createOrderPost'])->name('create.order.post');
    // Route::get('/cart/{id}', [CartController::class, 'addToCart'])->name('cart');
    Route::get('/cart/{id}', [CartController::class, 'cart'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'deleteFromCart'])->name('cart.delete');
    Route::get('/create-order', [OrderController::class, 'createOrder'])->name('create.order');
    Route::get('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
    Route::post('/place-order-post', [OrderController::class, 'placeOrderPost'])->name('place.order.post');
    Route::get('/update-wallet/{id}', [WalletController::class, 'updateWallet'])->name('update.wallet');
    Route::post('/update-wallet/{id}', [WalletController::class, 'updateWalletPost'])->name('update.wallet.post');
    Route::get('/checkout/{id}', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/order-details/{id}', [OrderController::class, 'orderDetails'])->name('order.details');
    Route::get('/order-details/order/{order_id}', [OrderController::class, 'orderDetailsPerOrder'])->name('order.details.per.order');
    Route::get('/generate-invoice/{order_id}', [OrderController::class, 'generateInvoice'])->name('generate.invoice');
    Route::get('/view-receipt/{receipt_id}', [WalletController::class, 'viewReceipt'])->name('view.receipt');
    Route::delete('/delete-receipt/{receipt_id}', [WalletController::class, 'deleteReceipt'])->name('delete.receipt');

});

