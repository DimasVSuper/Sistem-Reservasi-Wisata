<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Wisata;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:petugas_user');
    }

    public function index()
    {
        $totalDestinasi = Wisata::count();
        $totalPesanan = Reservasi::count();
        $totalPending = Reservasi::where('status', 'pending')->count();
        $totalRevenue = Reservasi::where('status', 'dikonfirmasi')->sum('total_harga');

        return view('admin.dashboard', compact(
            'totalDestinasi',
            'totalPesanan',
            'totalPending',
            'totalRevenue'
        ));
    }
}
