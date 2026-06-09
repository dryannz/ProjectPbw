<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPo;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class DetailPoController extends Controller
{
    /**
     * Tampilkan halaman detail barang dalam satu PO.
     */
    public function index(string $no_order)
    {
        $po = PurchaseOrder::with('customer')->findOrFail($no_order);

        $details = DetailPo::with('barang')
            ->where('no_order', $no_order)
            ->get();

        $grandTotalPcs   = $details->sum('total_pcs');
        $grandTotalKg    = $details->sum('total_kg');
        $grandTotalHarga = $details->sum('jumlah_harga');

        return view('podetail.index', compact(
            'po',
            'details',
            'grandTotalPcs',
            'grandTotalKg',
            'grandTotalHarga'
        ));
    }

    /**
     * Tampilkan form tambah detail barang.
     */
    public function create(string $no_order)
    {
        $po     = PurchaseOrder::with('customer')->findOrFail($no_order);
        $barangs = Barang::orderBy('ukuran')->get();

        return view('podetail.create', compact('po', 'barangs'));
    }

    /**
     * Simpan detail barang baru ke PO.
     */
    public function store(Request $request, string $no_order)
    {
        $po = PurchaseOrder::findOrFail($no_order);

        $validated = $request->validate([
            'idbarang'     => 'required|string|max:20|exists:barang,idbarang',
            'wrn'          => 'required|string|max:1',
            'jmlh_krg'     => 'required|integer|min:1',
            'pcs_krg'      => 'nullable|integer|min:0',
            'kg_krg'       => 'nullable|numeric|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'jumlah_harga' => 'required|numeric|min:0',
        ]);

        // Cek duplikat (no_order + idbarang)
        $exists = DetailPo::where('no_order', $no_order)
            ->where('idbarang', $validated['idbarang'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['idbarang' => 'Barang ini sudah ada dalam Purchase Order. Gunakan fitur Ubah.']);
        }

        $pcsKrg   = (int) ($validated['pcs_krg'] ?? 0);
        $kgKrg    = (float) ($validated['kg_krg'] ?? 0);
        $jmlhKrg  = (int) $validated['jmlh_krg'];

        DetailPo::create([
            'no_order'     => $no_order,
            'idbarang'     => $validated['idbarang'],
            'wrn'          => $validated['wrn'],
            'pcs_krg'      => $pcsKrg,
            'jmlh_krg'     => $jmlhKrg,
            'total_pcs'    => $pcsKrg * $jmlhKrg,
            'kg_krg'       => $kgKrg,
            'total_kg'     => $kgKrg * $jmlhKrg,
            'jumlah_harga' => (float) $validated['jumlah_harga'],
        ]);

        return redirect()
            ->route('purchaseorder.detail.index', $no_order)
            ->with('success', 'Detail barang berhasil ditambahkan.');
    }

    /**
     * Tampilkan form ubah detail barang.
     */
    public function edit(string $no_order, string $idbarang)
    {
        $po     = PurchaseOrder::with('customer')->findOrFail($no_order);
        $detail = DetailPo::with('barang')
            ->where('no_order', $no_order)
            ->where('idbarang', $idbarang)
            ->firstOrFail();

        return view('podetail.edit', compact('po', 'detail'));
    }

    /**
     * Update detail barang.
     */
    public function update(Request $request, string $no_order, string $idbarang)
    {
        $detail = DetailPo::where('no_order', $no_order)
            ->where('idbarang', $idbarang)
            ->firstOrFail();

        $validated = $request->validate([
            'wrn'      => 'required|string|max:1',
            'pcs_krg'  => 'required|integer|min:0',
            'jmlh_krg' => 'required|integer|min:1',
            'kg_krg'   => 'required|numeric|min:0',
        ]);

        $pcsKrg  = (int) $validated['pcs_krg'];
        $jmlhKrg = (int) $validated['jmlh_krg'];
        $kgKrg   = (float) $validated['kg_krg'];
        $harga   = (float) $detail->barang->harga;

        $totalPcs    = $pcsKrg * $jmlhKrg;
        $totalKg     = $kgKrg * $jmlhKrg;
        $jumlahHarga = $totalPcs * $harga;

        $detail->update([
            'wrn'          => $validated['wrn'],
            'pcs_krg'      => $pcsKrg,
            'jmlh_krg'     => $jmlhKrg,
            'total_pcs'    => $totalPcs,
            'kg_krg'       => $kgKrg,
            'total_kg'     => $totalKg,
            'jumlah_harga' => $jumlahHarga,
        ]);

        return redirect()
            ->route('purchaseorder.detail.index', $no_order)
            ->with('success', 'Detail barang berhasil diperbarui.');
    }

    /**
     * Hapus satu detail barang dari PO.
     */
    public function destroy(string $no_order, string $idbarang)
    {
        DetailPo::where('no_order', $no_order)
            ->where('idbarang', $idbarang)
            ->delete();

        return redirect()
            ->route('purchaseorder.detail.index', $no_order)
            ->with('success', 'Detail barang berhasil dihapus.');
    }
}
