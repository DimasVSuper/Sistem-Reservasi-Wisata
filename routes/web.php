<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinasiController;
use App\Http\Controllers\Admin\PesananController;
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
    return view('beranda');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard untuk semua user
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'petugas_user') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard.dashboard');
    })->name('dashboard');

    // CUSTOMER ROUTES
    Route::middleware('role:customer')->group(function () {
        Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
        Route::get('/reservasi/create', [ReservasiController::class, 'create'])->name('reservasi.create');
        Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
        Route::get('/reservasi/{reservasi}', [ReservasiController::class, 'show'])->name('reservasi.show');
        Route::put('/reservasi/{reservasi}/cancel', [ReservasiController::class, 'cancel'])->name('reservasi.cancel');
    });

    // ADMIN/PETUGAS ROUTES
    Route::prefix('admin')->name('admin.')->middleware('role:petugas_user')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Destinasi
        Route::resource('destinasi', DestinasiController::class);
        
        // Kelola Pesanan
        Route::resource('pesanan', PesananController::class)->only('index', 'show');
        Route::patch('/pesanan/{pesanan}/status/{status}', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    });
});



