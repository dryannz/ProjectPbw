<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Http\Requests\PetugasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * PetugasController
 * Menggantikan 4 file native:
 *   petugas-lihat.php  → index()
 *   petugas-tambah.php → create() + store()
 *   petugas-ubah.php   → edit()   + update()
 *   petugas-hapus.php  → destroy()  ← termasuk hapus file TTD dari storage
 */
class PetugasController extends Controller
{
    /**
     * petugas-lihat.php
     * Daftar petugas dengan pagination 5 per halaman.
     */
    public function index()
    {
        $petugas = Petugas::orderBy('idpetugas', 'asc')->paginate(5)->withQueryString();

        return view('petugas.index', compact('petugas'));
    }

    /**
     * petugas-tambah.php (GET)
     */
    public function create()
    {
        return view('petugas.create');
    }

    /**
     * petugas-tambah.php (POST)
     * Menyimpan petugas baru. Jika ada file TTD, upload ke storage/ttd/.
     */
    public function store(PetugasRequest $request)
    {
        $data = $request->validated();

        // Upload file tanda tangan jika ada
        if ($request->hasFile('ttdpetugas')) {
            $namaFile = time() . '_' . $request->file('ttdpetugas')->getClientOriginalName();
            $request->file('ttdpetugas')->storeAs('public/ttd', $namaFile);
            $data['ttdpetugas'] = $namaFile;
        }

        Petugas::create($data);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil disimpan!');
    }

    /**
     * petugas-ubah.php (GET)
     */
    public function edit(string $id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('petugas.edit', compact('petugas'));
    }

    /**
     * petugas-ubah.php (POST → PUT)
     * Update namapetugas dan jabatan. idpetugas tidak bisa diubah.
     * Jika ada file TTD baru, file lama dihapus dari storage.
     */
    public function update(PetugasRequest $request, string $id)
    {
        $petugas = Petugas::findOrFail($id);

        $data = $request->only(['namapetugas', 'jabatan']);

        // Ganti file TTD jika ada upload baru
        if ($request->hasFile('ttdpetugas')) {
            // Hapus file lama
            if ($petugas->ttdpetugas) {
                Storage::delete('public/ttd/' . $petugas->ttdpetugas);
            }

            $namaFile = time() . '_' . $request->file('ttdpetugas')->getClientOriginalName();
            $request->file('ttdpetugas')->storeAs('public/ttd', $namaFile);
            $data['ttdpetugas'] = $namaFile;
        }

        $petugas->update($data);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui!');
    }

    /**
     * petugas-hapus.php
     * Hapus petugas dan file TTD-nya dari storage (jika ada).
     * Native: unlink('../assets/images/uploads/ttd/' . $file_ttd)
     * Laravel: Storage::delete('public/ttd/' . $petugas->ttdpetugas)
     */
    public function destroy(string $id)
    {
        $petugas = Petugas::findOrFail($id);

        // Hapus file tanda tangan dari storage jika ada
        if (!empty($petugas->ttdpetugas)) {
            Storage::delete('public/ttd/' . $petugas->ttdpetugas);
        }

        $petugas->delete();

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data petugas berhasil dihapus.');
    }
}
