<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TicketController;
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
    return view('auth.login');
});

//Auth
Route::get('login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


//User dashboard
Route::middleware(['auth','user'])->group(function () {
Route::get('user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
Route::get('user/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('user/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
Route::get('user/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::get('user/tickets/{id}/chat-data', [TicketController::class, 'getChatData'])->name('tickets.chat-data');
Route::post('user/tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
Route::post('user/tickets/{id}/close', [TicketController::class, 'close'])->name('tickets.close');
Route::put('user/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('user/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

});


// Admin dashboard
Route::middleware(['auth','admin'])->group(function () {
Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('admin/tickets/{id}', [App\Http\Controllers\Admin\TicketController::class, 'show'])->name('admin.tickets.show');
Route::post('admin/tickets/{id}/status', [App\Http\Controllers\Admin\TicketController::class, 'updateStatus'])->name('admin.tickets.status');
Route::post('admin/tickets/{id}/comment', [App\Http\Controllers\Admin\TicketController::class, 'storeComment'])->name('admin.tickets.comment');
Route::get('admin/tickets/{id}/chat-data', [App\Http\Controllers\Admin\TicketController::class, 'getChatData'])->name('admin.tickets.chat-data');
// admin user management
Route::get('admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
Route::get('admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
Route::post('admin/users/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
Route::put('admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
Route::post('admin/users/{user}/update-password', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.users.update-password');
Route::delete('admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
// Admin Ranking
Route::get('admin/ranking', [App\Http\Controllers\Admin\RankingController::class, 'index'])->name('admin.ranking.index');

});
