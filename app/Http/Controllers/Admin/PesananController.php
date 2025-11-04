<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:petugas_user');
    }

    // Tampilkan daftar semua pesanan
    public function index()
    {
        $pesanans = Reservasi::with(['user', 'wisata'])->latest()->get();
        return view('admin.pesanan.index', compact('pesanans'));
    }

    // Lihat detail pesanan
    public function show(Reservasi $pesanan)
    {
        $pesanan->load(['user', 'wisata']);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    // Update status pesanan
    public function updateStatus(Reservasi $pesanan, $status)
    {
        if (!in_array($status, ['pending', 'dikonfirmasi', 'dibatalkan'])) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid'
                ], 400);
            }
            return back()->with('error', 'Status tidak valid');
        }

        $pesanan->update(['status' => $status]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui!'
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
