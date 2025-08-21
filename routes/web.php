<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,User');

Route::get('/resident', [ResidentController::class, 'index'])->middleware('role:Admin');
Route::get('/resident/create', [ResidentController::class, 'create'])->middleware('role:Admin');
Route::get('/resident/{id}/edit', [ResidentController::class, 'edit'])->middleware('role:Admin');
Route::post('/resident', [ResidentController::class, 'store'])->middleware('role:Admin');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->middleware('role:Admin');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->middleware('role:Admin');

Route::get('/account-list', [UserController::class, 'accountListView'])->middleware('role:Admin');

Route::get('/account-request', [UserController::class, 'accountRequestView'])->middleware('role:Admin');
Route::post('/account-request/approval/{id}', [UserController::class, 'accountRequestApproval'])->middleware('role:Admin');

Route::middleware(['auth'])->group(function () {
    // ...
    Route::get('/account-list', [UserController::class, 'accountListView'])->name('users.list');
    
    // Route untuk menonaktifkan akun
    Route::patch('/users/{id}/deactivate', [UserController::class, 'deactivateAccount'])->name('users.deactivate');
    
    // Route untuk menghapus satu akun
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Route untuk menghapus akun secara massal
    Route::delete('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulkDestroy');
    // ...
});

// Route untuk menampilkan halaman profil pengguna
Route::get('/profile', [UserController::class, 'profileView'])
    ->middleware('role:Admin,User')
    ->name('profile.index'); // Nama rute ditambahkan

// Route untuk memproses pembaruan data profil
Route::put('/profile/{id}', [UserController::class, 'updateProfile'])
    ->middleware('role:Admin,User')
    ->name('profile.update'); // Metode diubah ke PUT dan nama rute ditambahkan

// Route untuk menampilkan halaman ganti password
Route::get('/change-password', [UserController::class, 'changePasswordView'])
    ->middleware('role:Admin,User')
    ->name('profile.change-password'); // Nama rute ditambahkan

// Route untuk memproses pembaruan password
Route::put('/change-password', [UserController::class, 'updatePassword'])
    ->middleware('role:Admin,User')
    ->name('profile.update-password'); 