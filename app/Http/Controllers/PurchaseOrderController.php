<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Tampilkan daftar purchase order dengan paginasi.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('customer')
            ->orderBy('no_order', 'asc')
            ->paginate(5);

        return view('purchaseorder.index', compact('purchaseOrders'));
    }

    /**
     * Tampilkan form tambah purchase order.
     */
    public function create()
    {
        $customers = Customer::orderBy('kepada_yth')->get();

        return view('purchaseorder.create', compact('customers'));
    }

    /**
     * Simpan purchase order baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_order'          => 'required|string|max:70|unique:purchase_order,no_order',
            'idcustomer'        => 'required|string|max:20|exists:customer,idcustomer',
            'tgl_order'         => 'required|date',
            'schedule_delivery' => 'required|date',
        ], [
            'no_order.unique'        => 'No Purchase Order sudah ada! Gunakan nomor lain.',
            'idcustomer.exists'      => 'Customer tidak ditemukan.',
        ]);

        PurchaseOrder::create($validated);

        return redirect()
            ->route('purchaseorder.detail.index', $validated['no_order'])
            ->with('success', 'Purchase Order berhasil disimpan.');
    }

    /**
     * Tampilkan form ubah purchase order.
     */
    public function edit(string $no_order)
    {
        $po        = PurchaseOrder::findOrFail($no_order);
        $customers = Customer::orderBy('kepada_yth')->get();

        return view('purchaseorder.edit', compact('po', 'customers'));
    }

    /**
     * Update purchase order.
     */
    public function update(Request $request, string $no_order)
    {
        $po = PurchaseOrder::findOrFail($no_order);

        $validated = $request->validate([
            'idcustomer'        => 'required|string|max:20|exists:customer,idcustomer',
            'tgl_order'         => 'required|date',
            'schedule_delivery' => 'required|date',
        ]);

        $po->update($validated);

        return redirect()
            ->route('purchaseorder.index')
            ->with('success', 'Purchase Order berhasil diperbarui.');
    }

    /**
     * Hapus purchase order (beserta detail_po karena onDelete cascade).
     */
    public function destroy(string $no_order)
    {
        $po = PurchaseOrder::findOrFail($no_order);
        $po->delete();

        return redirect()
            ->route('purchaseorder.index')
            ->with('success', 'Purchase Order berhasil dihapus.');
    }
}
