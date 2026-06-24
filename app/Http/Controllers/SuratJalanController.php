<?php

namespace App\Http\Controllers;

use App\Models\DetailSuratJalan;
use App\Models\Invoice;
use App\Models\Petugas;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratJalanController extends Controller
{
    // -----------------------------------------------------------------------
    // INDEX — daftar surat jalan dengan pagination & info invoice/order
    // -----------------------------------------------------------------------
    public function index()
    {
        $suratJalans = SuratJalan::query()
            ->select([
                'surat_jalan.no_surat',
                'surat_jalan.no_invoice',
                'surat_jalan.idpetugas_admin',
                'surat_jalan.idpetugas_warehouse',
                'surat_jalan.idpetugas_driver',
                'surat_jalan.tgl_surat',
                'surat_jalan.subtotal',
                'pa.namapetugas as nama_admin',
                'pw.namapetugas as nama_warehouse',
                'pd.namapetugas as nama_driver',
                DB::raw("GROUP_CONCAT(DISTINCT dsj.no_invoice ORDER BY dsj.no_invoice DESC SEPARATOR ', ') AS semua_no_invoice"),
                DB::raw("GROUP_CONCAT(DISTINCT di.no_order  ORDER BY di.no_order  DESC SEPARATOR ', ') AS semua_no_order"),
            ])
            ->leftJoin('petugas as pa', 'surat_jalan.idpetugas_admin',     '=', 'pa.idpetugas')
            ->leftJoin('petugas as pw', 'surat_jalan.idpetugas_warehouse',  '=', 'pw.idpetugas')
            ->leftJoin('petugas as pd', 'surat_jalan.idpetugas_driver',     '=', 'pd.idpetugas')
            ->leftJoin('detail_surat_jalan as dsj', 'dsj.no_surat',         '=', 'surat_jalan.no_surat')
            ->leftJoin('detail_invoice as di',       'di.no_invoice',        '=', 'dsj.no_invoice')
            ->groupBy(
                'surat_jalan.no_surat',
                'surat_jalan.no_invoice',
                'surat_jalan.idpetugas_admin',
                'surat_jalan.idpetugas_warehouse',
                'surat_jalan.idpetugas_driver',
                'surat_jalan.tgl_surat',
                'surat_jalan.subtotal',
                'pa.namapetugas',
                'pw.namapetugas',
                'pd.namapetugas'
            )
            ->orderBy('surat_jalan.no_surat')
            ->paginate(5);

        return view('suratjalan.index', compact('suratJalans'));
    }

    // -----------------------------------------------------------------------
    // CREATE — tampilkan form tambah
    // -----------------------------------------------------------------------
    public function create()
    {
        $invoices  = Invoice::orderBy('no_invoice')->pluck('no_invoice', 'no_invoice');
        $admins    = Petugas::where('jabatan', 'Admin')->orderBy('namapetugas')->get();
        $warehouses = Petugas::where('jabatan', 'Warehouse')->orderBy('namapetugas')->get();
        $drivers   = Petugas::where('jabatan', 'Driver')->orderBy('namapetugas')->get();

        return view('suratjalan.create', compact('invoices', 'admins', 'warehouses', 'drivers'));
    }

    // -----------------------------------------------------------------------
    // STORE — simpan surat jalan baru
    // -----------------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'no_surat'             => 'required|string|unique:surat_jalan,no_surat',
            'no_invoice'           => 'required|string|exists:invoice,no_invoice',
            'idpetugas_admin'      => 'required|exists:petugas,idpetugas',
            'idpetugas_warehouse'  => 'required|exists:petugas,idpetugas',
            'idpetugas_driver'     => 'required|exists:petugas,idpetugas',
            'tgl_surat'            => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $sj = SuratJalan::create($request->only([
                'no_surat', 'no_invoice',
                'idpetugas_admin', 'idpetugas_warehouse', 'idpetugas_driver',
                'tgl_surat',
            ]));

            // Simpan ke detail_surat_jalan (ignore duplicate)
            DetailSuratJalan::firstOrCreate([
                'no_surat'   => $sj->no_surat,
                'no_invoice' => $request->no_invoice,
            ]);
        });

        return redirect()->route('suratjalan.detail', $request->no_surat)
            ->with('success', 'Surat Jalan berhasil disimpan.');
    }

    // -----------------------------------------------------------------------
    // DETAIL — detail surat jalan
    // -----------------------------------------------------------------------
    public function detail(string $no_surat)
    {
        $dataSj = SuratJalan::with(['admin', 'warehouse', 'driver'])
            ->where('no_surat', $no_surat)
            ->firstOrFail();

        [$linkedInvoices, $linkedOrders, $customerName, $rows,
         $subTotalKrg, $subTotalPcs, $subTotalKg] = $this->resolveDetailData($no_surat);

        return view('suratjalan.detail', compact(
            'dataSj', 'linkedInvoices', 'linkedOrders',
            'customerName', 'rows', 'subTotalKrg', 'subTotalPcs', 'subTotalKg'
        ));
    }

    // -----------------------------------------------------------------------
    // EDIT — form ubah
    // -----------------------------------------------------------------------
    public function edit(string $no_surat)
    {
        $suratJalan = SuratJalan::where('no_surat', $no_surat)->firstOrFail();
        $invoices   = Invoice::orderBy('no_invoice')->pluck('no_invoice', 'no_invoice');
        $admins     = Petugas::where('jabatan', 'Admin')->orderBy('namapetugas')->get();
        $warehouses = Petugas::where('jabatan', 'Warehouse')->orderBy('namapetugas')->get();
        $drivers    = Petugas::where('jabatan', 'Driver')->orderBy('namapetugas')->get();

        return view('suratjalan.edit', compact(
            'suratJalan', 'invoices', 'admins', 'warehouses', 'drivers'
        ));
    }

    // -----------------------------------------------------------------------
    // UPDATE — simpan perubahan
    // -----------------------------------------------------------------------
    public function update(Request $request, string $no_surat)
    {
        $request->validate([
            'no_invoice'           => 'required|string|exists:invoice,no_invoice',
            'idpetugas_admin'      => 'required|exists:petugas,idpetugas',
            'idpetugas_warehouse'  => 'required|exists:petugas,idpetugas',
            'idpetugas_driver'     => 'required|exists:petugas,idpetugas',
            'tgl_surat'            => 'required|date',
            'subtotal'             => 'nullable|numeric|min:0',
        ]);

        $suratJalan = SuratJalan::where('no_surat', $no_surat)->firstOrFail();

        DB::transaction(function () use ($request, $suratJalan, $no_surat) {
            $suratJalan->update($request->only([
                'no_invoice',
                'idpetugas_admin', 'idpetugas_warehouse', 'idpetugas_driver',
                'tgl_surat', 'subtotal',
            ]));

            // Sync detail surat jalan
            DetailSuratJalan::where('no_surat', $no_surat)->delete();
            DetailSuratJalan::create([
                'no_surat'   => $no_surat,
                'no_invoice' => $request->no_invoice,
            ]);
        });

        return redirect()->route('suratjalan.index')
            ->with('success', 'Surat Jalan berhasil diperbarui.');
    }

    // -----------------------------------------------------------------------
    // DESTROY — hapus surat jalan
    // -----------------------------------------------------------------------
    public function destroy(string $no_surat)
    {
        $suratJalan = SuratJalan::where('no_surat', $no_surat)->firstOrFail();
        $suratJalan->delete(); // detail_surat_jalan ter-cascade

        return redirect()->route('suratjalan.index')
            ->with('success', 'Surat Jalan berhasil dihapus.');
    }

    // -----------------------------------------------------------------------
    // CETAK — tampilkan versi cetak (ori/copy1/copy2/copy3)
    // -----------------------------------------------------------------------
    public function cetak(string $no_surat, Request $request)
    {
        $dataSj = SuratJalan::with(['admin', 'warehouse', 'driver'])
            ->where('no_surat', $no_surat)
            ->firstOrFail();

        $copyMap   = ['ori' => 'ORI', 'copy1' => 'COPY 1', 'copy2' => 'COPY 2', 'copy3' => 'COPY 3'];
        $copy      = $request->query('copy', 'ori');
        $copyLabel = $copyMap[$copy] ?? 'ORI';

        [$linkedInvoices, $linkedOrders, $customerName, $rows,
         $subTotalKrg, $subTotalPcs, $subTotalKg, $customerAddress] = $this->resolveDetailData($no_surat, true);

        $limit      = 12; // maks baris per halaman A4
        $chunks     = !empty($rows) ? array_chunk($rows, $limit) : [[]];
        $totalPages = count($chunks);

        return view('suratjalan.cetak', compact(
            'dataSj', 'copyLabel', 'linkedInvoices', 'linkedOrders',
            'customerName', 'customerAddress', 'chunks', 'totalPages',
            'subTotalKrg', 'subTotalPcs', 'subTotalKg'
        ));
    }

    // -----------------------------------------------------------------------
    // HELPER PRIVATE — ambil data barang & customer dari chain relasi
    // -----------------------------------------------------------------------
    private function resolveDetailData(string $no_surat, bool $withAddress = false): array
    {
        // 1. Ambil daftar invoice yang terhubung ke surat jalan ini
        $linkedInvoices = DetailSuratJalan::where('no_surat', $no_surat)
            ->orderBy('no_invoice')
            ->pluck('no_invoice')
            ->toArray();

        $linkedOrders    = [];
        $customerName    = '- (Belum ada Order)';
        $customerAddress = '-';
        $rows            = [];
        $subTotalKrg     = 0;
        $subTotalPcs     = 0;
        $subTotalKg      = 0;

        if (empty($linkedInvoices)) {
            return [$linkedInvoices, $linkedOrders, $customerName, $rows,
                    $subTotalKrg, $subTotalPcs, $subTotalKg, $customerAddress];
        }

        // 2. Ambil semua no_order dari detail_invoice
        $linkedOrders = DB::table('detail_invoice')
            ->whereIn('no_invoice', $linkedInvoices)
            ->orderBy('no_order')
            ->pluck('no_order')
            ->toArray();

        if (empty($linkedOrders)) {
            return [$linkedInvoices, $linkedOrders, $customerName, $rows,
                    $subTotalKrg, $subTotalPcs, $subTotalKg, $customerAddress];
        }

        // 3. Ambil nama (dan alamat) customer
        $custCols = $withAddress ? ['c.kepada_yth', 'c.alamat'] : ['c.kepada_yth'];
        $custData = DB::table('purchase_order as po')
            ->join('customer as c', 'po.idcustomer', '=', 'c.idcustomer')
            ->whereIn('po.no_order', $linkedOrders)
            ->select($custCols)
            ->first();

        if ($custData) {
            $customerName    = $custData->kepada_yth;
            $customerAddress = $withAddress ? $custData->alamat : '-';
        }

        // 4. Ambil detail barang
        $details = DB::table('detail_po as dp')
            ->join('barang as b', 'dp.idbarang', '=', 'b.idbarang')
            ->whereIn('dp.no_order', $linkedOrders)
            ->select(['dp.*', 'b.ukuran', 'b.ukuran_tamu', 'b.harga'])
            ->orderBy('dp.no_order')
            ->orderBy('dp.idbarang')
            ->get();

        foreach ($details as $row) {
            $subTotalKrg += $row->jmlh_krg;
            $subTotalPcs += $row->total_pcs;
            $subTotalKg  += $row->total_kg;
            $rows[]       = (array) $row;
        }

        return [$linkedInvoices, $linkedOrders, $customerName, $rows,
                $subTotalKrg, $subTotalPcs, $subTotalKg, $customerAddress];
    }
}
