<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Wisata;
use App\Models\Reservasi;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes (untuk guest users)
Route::get('/destinasi', function (Request $request) {
    $query = Wisata::query();
    
    // Search berdasarkan nama, lokasi, atau deskripsi
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where('nama', 'like', "%$search%")
              ->orWhere('lokasi', 'like', "%$search%")
              ->orWhere('deskripsi', 'like', "%$search%");
    }
    
    $destinasi = $query->latest()->get()->map(function ($item) {
        return [
            'id' => $item->id,
            'nama' => $item->nama,
            'deskripsi' => $item->deskripsi,
            'lokasi' => $item->lokasi,
            'harga' => $item->harga,
            'kapasitas' => $item->kapasitas,
            'status' => $item->status,
        ];
    });
    
    return response()->json([
        'success' => true,
        'data' => $destinasi
    ]);
});

Route::get('/stats', function () {
    $totalDestinasi = Wisata::count();
    $totalReservasi = Reservasi::count();
    $totalCustomer = User::where('role', 'customer')->count();
    
    return response()->json([
        'totalDestinasi' => $totalDestinasi,
        'totalReservasi' => $totalReservasi,
        'totalCustomer' => $totalCustomer,
    ]);
});

