<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    // Middleware untuk auth
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:customer');
    }

    // Tampilkan form reservasi
    public function create()
    {
        $wisatas = Wisata::where('status', 'tersedia')->get();
        return view('reservasi.create', compact('wisatas'));
    }

    // Store reservasi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wisata_id' => ['required', 'exists:wisatas,id'],
            'tanggal_reservasi' => ['required', 'date', 'after:today'],
            'jumlah_orang' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string'],
        ]);

        // Ambil data wisata
        $wisata = Wisata::findOrFail($validated['wisata_id']);

        // Hitung total harga
        $total_harga = $wisata->harga * $validated['jumlah_orang'];

        // Buat reservasi
        $reservasi = Auth::user()->reservasis()->create([
            'wisata_id' => $validated['wisata_id'],
            'tanggal_reservasi' => $validated['tanggal_reservasi'],
            'jumlah_orang' => $validated['jumlah_orang'],
            'total_harga' => $total_harga,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat! Status: Pending');
    }

    // Tampilkan daftar reservasi
    public function index()
    {
        $reservasis = Auth::user()->reservasis()->with('wisata')->latest()->get();
        return view('reservasi.index', compact('reservasis'));
    }

    // Tampilkan detail reservasi
    public function show(Reservasi $reservasi)
    {
        // Cek apakah user adalah pemilik reservasi
        if ($reservasi->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reservasi.show', compact('reservasi'));
    }

    // Batalkan reservasi
    public function cancel(Reservasi $reservasi)
    {
        // Cek apakah user adalah pemilik reservasi
        if ($reservasi->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa batalkan jika status pending
        if ($reservasi->status !== 'pending') {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya reservasi dengan status pending yang dapat dibatalkan'
                ], 400);
            }
            return back()->with('error', 'Hanya reservasi dengan status pending yang dapat dibatalkan');
        }

        $reservasi->update(['status' => 'dibatalkan']);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibatalkan'
            ]);
        }

        return back()->with('success', 'Reservasi berhasil dibatalkan');
    }
}
