<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::orderBy('idpetugas', 'desc')->paginate(5)->withQueryString();

        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $isAdmin = strtolower(trim($request->jabatan)) === 'admin';

        $rules = [
            'idpetugas'   => 'required|string|unique:petugas,idpetugas',
            'namapetugas' => 'required|string|max:255',
            'jabatan'     => 'required|string|max:100',
        ];

        // Password wajib diisi hanya jika jabatan Admin
        if ($isAdmin) {
            $rules['password'] = 'required|string|min:6';
        }

        $request->validate($rules);

        $data = [
            'idpetugas'   => $request->idpetugas,
            'namapetugas' => $request->namapetugas,
            'jabatan'     => $request->jabatan,
        ];

        // Hash password jika jabatan Admin dan password diisi
        if ($isAdmin && $request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        Petugas::create($data);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil disimpan!');
    }

    public function edit(string $id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, string $id)
    {
        $petugas = Petugas::findOrFail($id);

        $isAdmin = strtolower(trim($request->jabatan)) === 'admin';

        $rules = [
            'namapetugas' => 'required|string|max:255',
            'jabatan'     => 'required|string|max:100',
        ];

        // Password opsional saat edit, tapi jika diisi minimal 6 karakter
        if ($isAdmin && $request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        $request->validate($rules);

        $data = [
            'namapetugas' => $request->namapetugas,
            'jabatan'     => $request->jabatan,
        ];

        // Update password hanya jika jabatan Admin dan field password diisi
        if ($isAdmin && $request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Jika jabatan diubah dari Admin ke non-Admin, hapus password
        if (!$isAdmin) {
            $data['password'] = null;
        }

        $petugas->update($data);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil dihapus.');
    }
}