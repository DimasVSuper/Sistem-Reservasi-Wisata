<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:petugas_user');
    }

    // Tampilkan daftar destinasi
    public function index()
    {
        $destinasis = Wisata::latest()->get();
        return view('admin.destinasi.index', compact('destinasis'));
    }

    // Form tambah destinasi
    public function create()
    {
        return view('admin.destinasi.create');
    }

    // Simpan destinasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'lokasi' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:1000'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        Wisata::create($validated);

        return redirect()->route('admin.destinasi.index')->with('success', 'Destinasi wisata berhasil ditambahkan!');
    }

    // Form edit destinasi
    public function edit(Wisata $destinasi)
    {
        return view('admin.destinasi.edit', compact('destinasi'));
    }

    // Update destinasi
    public function update(Request $request, Wisata $destinasi)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'lokasi' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:1000'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:tersedia,penuh'],
        ]);

        $destinasi->update($validated);

        return redirect()->route('admin.destinasi.index')->with('success', 'Destinasi wisata berhasil diperbarui!');
    }

    // Hapus destinasi
    public function destroy(Wisata $destinasi)
    {
        // Cek apakah ada reservasi aktif
        $hasActiveReservasi = Reservasi::where('wisata_id', $destinasi->id)
            ->whereIn('status', ['pending', 'dikonfirmasi'])
            ->exists();

        if ($hasActiveReservasi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa hapus destinasi yang memiliki reservasi aktif!'
            ], 400);
        }

        $destinasi->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Destinasi wisata berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.destinasi.index')->with('success', 'Destinasi wisata berhasil dihapus!');
    }
}
