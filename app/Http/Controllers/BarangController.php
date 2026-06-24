<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;


class BarangController extends Controller
{
    /**
     * barang-lihat.php
     * Menampilkan daftar barang dengan pagination (5 per halaman).
     */
    public function index(Request $request)
    {
        $barangs = Barang::orderBy('idbarang', 'desc')
            ->paginate(5)
            ->withQueryString(); // agar parameter ?search tetap saat pindah halaman

        return view('barang.index', compact('barangs'));
    }

    /**
     * barang-tambah.php (GET)
     * Tampilkan form tambah barang.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * barang-tambah.php (POST)
     * Proses simpan barang baru.
     */
    public function store(Request $request) // Ubah parameter di sini
    {
        // 1. Tambahkan validasi manual di sini
        $validated = $request->validate([
            'idbarang'    => 'required|unique:barang,idbarang',
            'ukuran'      => 'required|string',
            'ukuran_tamu' => 'nullable|string',
            'harga'       => 'required|numeric'
        ]);

        Barang::create($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil disimpan!');
    }

    /**
     * barang-ubah.php (GET)
     * Tampilkan form edit dengan data lama.
     */
    public function edit(string $id)
    {
        // Jika ID tidak ditemukan → redirect seperti perilaku native
        $barang = Barang::findOrFail($id);

        return view('barang.edit', compact('barang'));
    }

    /**
     * barang-ubah.php (POST)
     * Proses update data barang.
     * idbarang tidak bisa diubah (readonly di form).
     */
    public function update(Request $request, string $id) // Ubah parameter di sini
    {
        // 1. Tambahkan validasi manual di sini
        $request->validate([
            'ukuran'      => 'required|string',
            'ukuran_tamu' => 'nullable|string',
            'harga'       => 'required|numeric'
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update($request->only(['ukuran', 'ukuran_tamu', 'harga']));

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * barang-hapus.php
     * Hapus data barang berdasarkan ID.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }
}
