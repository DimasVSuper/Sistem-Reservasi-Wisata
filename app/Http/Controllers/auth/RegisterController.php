<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle register
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'hp' => ['required', 'string', 'regex:/^[0-9]{10,13}$/', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);
        
        // Set default role dan status
        $validated['role'] = 'customer';
        $validated['status'] = 'active';

        // Buat user baru
        $user = User::create($validated);

        // Auto login setelah register
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang!');
    }

    
}
