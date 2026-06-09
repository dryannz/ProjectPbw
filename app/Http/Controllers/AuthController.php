<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'idpetugas'     => 'required',
            'password' => 'required',
        ]);

        $petugas = Petugas::where('idpetugas', $request->idpetugas)->first();

        // Cek nama ada + password cocok
        if (!$petugas || !Hash::check($request->password, $petugas->password)) {
            return back()
                ->withErrors(['idpetugas' => 'ID Petugas atau password salah.'])
                ->withInput();
        }

        \Illuminate\Support\Facades\Auth::login($petugas);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}