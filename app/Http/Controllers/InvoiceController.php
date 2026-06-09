<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\DetailInvoice;
use App\Models\Petugas;
use App\Models\PurchaseOrder;
use App\Models\DetailPo;
use App\Models\Customer;

class InvoiceController extends Controller
{
    // ─── Helper: terbilang ───────────────────────────────────────────────────
    private function terbilang(float $angka): string
    {
        $angka = abs($angka);
        $baca  = ['', 'satu', 'dua', 'tiga', 'empat', 'lima',
                  'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($angka < 12)           return ' ' . $baca[(int)$angka];
        if ($angka < 20)           return $this->terbilang($angka - 10) . ' belas';
        if ($angka < 100)          return $this->terbilang(floor($angka / 10)) . ' puluh' . $this->terbilang(fmod($angka, 10));
        if ($angka < 200)          return ' seratus' . $this->terbilang($angka - 100);
        if ($angka < 1000)         return $this->terbilang(floor($angka / 100)) . ' ratus' . $this->terbilang(fmod($angka, 100));
        if ($angka < 2000)         return ' seribu' . $this->terbilang($angka - 1000);
        if ($angka < 1000000)      return $this->terbilang(floor($angka / 1000)) . ' ribu' . $this->terbilang(fmod($angka, 1000));
        if ($angka < 1000000000)   return $this->terbilang(floor($angka / 1000000)) . ' juta' . $this->terbilang(fmod($angka, 1000000));
        if ($angka < 1000000000000) return $this->terbilang(floor($angka / 1000000000)) . ' milyar' . $this->terbilang(fmod($angka, 1000000000));

        return $this->terbilang(floor($angka / 1000000000000)) . ' trilyun' . $this->terbilang(fmod($angka, 1000000000000));
    }

    // ─── Helper: ambil detail barang dari banyak no_order ───────────────────
    private function getDetailRows(array $linkedOrders): array
    {
        if (empty($linkedOrders)) {
            return [[], 0, 0, 0, 0];
        }

        $rows = DetailPo::with('barang')
            ->whereIn('no_order', $linkedOrders)
            ->orderBy('no_order')
            ->orderBy('idbarang')
            ->get();

        $subKrg   = 0;
        $subPcs   = 0;
        $subKg    = 0;
        $subHarga = 0;

        $result = $rows->map(function ($dp) use (&$subKrg, &$subPcs, &$subKg, &$subHarga) {
            $subKrg   += $dp->jmlh_krg;
            $subPcs   += $dp->total_pcs;
            $subKg    += $dp->total_kg;
            $subHarga += $dp->jumlah_harga;

            return (object) [
                'no_order'     => $dp->no_order,
                'ukuran'       => $dp->barang->ukuran ?? '-',
                'ukuran_tamu'  => $dp->barang->ukuran_tamu ?? '-',
                'wrn'          => $dp->wrn,
                'pcs_krg'      => $dp->pcs_krg,
                'jmlh_krg'     => $dp->jmlh_krg,
                'total_pcs'    => $dp->total_pcs,
                'kg_krg'       => $dp->kg_krg,
                'total_kg'     => $dp->total_kg,
                'harga'        => $dp->barang->harga ?? 0,
                'jumlah_harga' => $dp->jumlah_harga,
            ];
        })->toArray();

        return [$result, $subKrg, $subPcs, $subKg, $subHarga];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // INDEX – daftar invoice dengan pagination
    // ─────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $invoices = DB::table('invoice as i')
            ->join('petugas as p', 'p.idpetugas', '=', 'i.idpetugas_admin')
            ->leftJoin('detail_invoice as di', 'di.no_invoice', '=', 'i.no_invoice')
            ->select(
                'i.no_invoice',
                'i.idpetugas_admin',
                'i.no_order',
                'i.tgl_invoice',
                'p.namapetugas',
                DB::raw("GROUP_CONCAT(di.no_order ORDER BY di.no_order ASC SEPARATOR ', ') AS semua_no_order")
            )
            ->groupBy('i.no_invoice', 'i.idpetugas_admin', 'i.no_order', 'i.tgl_invoice', 'p.namapetugas')
            ->orderBy('i.no_invoice')
            ->paginate(5);

        return view('invoice.index', compact('invoices'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CREATE – form tambah invoice
    // ─────────────────────────────────────────────────────────────────────────
    public function create()
    {
        $petugasList = Petugas::where('jabatan', 'Admin')->get();
        $poList      = PurchaseOrder::orderBy('no_order')->get();

        return view('invoice.tambah', compact('petugasList', 'poList'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // STORE – simpan invoice baru
    // ─────────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'no_invoice'      => 'required|string|max:70|unique:invoice,no_invoice',
            'idpetugas_admin' => 'required|string|max:20',
            'no_order'        => 'required|string|max:70',
            'tgl_invoice'     => 'required|date',
        ], [
            'no_invoice.unique' => 'No Invoice sudah ada! Gunakan nomor lain.',
        ]);

        DB::transaction(function () use ($request) {
            Invoice::create([
                'no_invoice'      => $request->no_invoice,
                'idpetugas_admin' => $request->idpetugas_admin,
                'no_order'        => $request->no_order,
                'tgl_invoice'     => $request->tgl_invoice,
            ]);

            if (!empty($request->no_order)) {
                DetailInvoice::insertOrIgnore([
                    'no_invoice' => $request->no_invoice,
                    'no_order'   => $request->no_order,
                ]);
            }
        });

        return redirect()->route('invoice.detail', $request->no_invoice)
                         ->with('success', 'Invoice berhasil disimpan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EDIT – form ubah invoice
    // ─────────────────────────────────────────────────────────────────────────
    public function edit(string $no_invoice)
    {
        $invoice     = Invoice::findOrFail($no_invoice);
        $petugasList = Petugas::all();
        $poList      = PurchaseOrder::orderBy('no_order')->get();

        return view('invoice.ubah', compact('invoice', 'petugasList', 'poList'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UPDATE – simpan perubahan invoice
    // ─────────────────────────────────────────────────────────────────────────
    public function update(Request $request, string $no_invoice)
    {
        $invoice = Invoice::findOrFail($no_invoice);

        $request->validate([
            'idpetugas_admin' => 'required|string|max:20',
            'no_order'        => 'required|string|max:70',
            'tgl_invoice'     => 'required|date',
            'subtotal'        => 'nullable|numeric',
            'ppn'             => 'nullable|numeric',
            'dpp'             => 'nullable|numeric',
        ]);

        $oldNoOrder = $invoice->no_order;
        $newNoOrder = $request->no_order;

        DB::transaction(function () use ($invoice, $request, $no_invoice, $oldNoOrder, $newNoOrder) {
            $invoice->update([
                'idpetugas_admin' => $request->idpetugas_admin,
                'no_order'        => $newNoOrder,
                'tgl_invoice'     => $request->tgl_invoice,
                'subtotal'        => $request->subtotal ?? 0,
                'ppn'             => $request->ppn ?? 0,
                'dpp'             => $request->dpp ?? 0,
            ]);

            // Sinkronisasi detail_invoice jika no_order berubah
            if ($oldNoOrder !== $newNoOrder) {
                if (!empty($oldNoOrder)) {
                    DetailInvoice::where('no_invoice', $no_invoice)
                                 ->where('no_order', $oldNoOrder)
                                 ->delete();
                }
                if (!empty($newNoOrder)) {
                    DetailInvoice::insertOrIgnore([
                        'no_invoice' => $no_invoice,
                        'no_order'   => $newNoOrder,
                    ]);
                }
            }
        });

        return redirect()->route('invoice.index')
                         ->with('success', 'Invoice berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DESTROY – hapus invoice
    // ─────────────────────────────────────────────────────────────────────────
    public function destroy(string $no_invoice)
    {
        Invoice::findOrFail($no_invoice)->delete();

        return redirect()->route('invoice.index')
                         ->with('success', 'Invoice berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DETAIL – lihat detail invoice + manage linked orders
    // ─────────────────────────────────────────────────────────────────────────
    public function detail(string $no_invoice)
    {
        $invoice = Invoice::with('petugas')->findOrFail($no_invoice);

        // Daftar no_order yang terhubung
        $linkedOrders = DetailInvoice::where('no_invoice', $no_invoice)
                                     ->orderBy('no_order')
                                     ->pluck('no_order')
                                     ->toArray();

        // idcustomer dari PO pertama (untuk pembatasan tambah order)
        $firstPoIdcustomer = null;
        if (!empty($linkedOrders)) {
            $firstPo = PurchaseOrder::where('no_order', $linkedOrders[0])->first();
            $firstPoIdcustomer = $firstPo?->idcustomer;
        }

        // Nama customer
        $customerName = '- (Belum ada Order)';
        if (!empty($linkedOrders)) {
            $cust = DB::table('purchase_order as po')
                ->join('customer as c', 'c.idcustomer', '=', 'po.idcustomer')
                ->whereIn('po.no_order', $linkedOrders)
                ->select('c.kepada_yth')
                ->first();
            if ($cust) $customerName = $cust->kepada_yth;
        }

        // Rekap barang
        [$rows, $subKrg, $subPcs, $subKg, $subHarga] = $this->getDetailRows($linkedOrders);

        // Hitung & update PPN 12% otomatis
        $calculatedPpn = (int) round(0.12 * $subHarga);
        if ($calculatedPpn != $invoice->ppn) {
            $invoice->update(['ppn' => $calculatedPpn]);
            $invoice->ppn = $calculatedPpn;
        }

        $grandTotal = $subHarga + $invoice->ppn + $invoice->dpp;

        // PO yang tersedia untuk ditambahkan (belum terhubung, customer sama)
        $availablePo = PurchaseOrder::whereNotIn('no_order',
                            DetailInvoice::where('no_invoice', $no_invoice)->pluck('no_order'))
            ->when($firstPoIdcustomer, fn($q) => $q->where('idcustomer', $firstPoIdcustomer))
            ->orderBy('no_order')
            ->get();

        return view('invoice.detail', compact(
            'invoice', 'linkedOrders', 'customerName',
            'rows', 'subKrg', 'subPcs', 'subKg', 'subHarga',
            'grandTotal', 'availablePo'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ADD ORDER – tambah no_order ke detail_invoice
    // ─────────────────────────────────────────────────────────────────────────
    public function addOrder(Request $request, string $no_invoice)
    {
        $request->validate(['no_order' => 'required|string|max:70']);

        Invoice::findOrFail($no_invoice);

        // Cek customer sama dengan PO pertama
        $linkedOrders = DetailInvoice::where('no_invoice', $no_invoice)
                                     ->pluck('no_order')
                                     ->toArray();
        if (!empty($linkedOrders)) {
            $firstPo = PurchaseOrder::where('no_order', $linkedOrders[0])->first();
            $newPo   = PurchaseOrder::where('no_order', $request->no_order)->first();

            if ($firstPo && $newPo && $firstPo->idcustomer !== $newPo->idcustomer) {
                return redirect()->route('invoice.detail', $no_invoice)
                    ->with('error', 'Gagal: Nomor Order harus berasal dari customer yang sama dengan Order pertama!');
            }
        }

        DetailInvoice::insertOrIgnore([
            'no_invoice' => $no_invoice,
            'no_order'   => $request->no_order,
        ]);

        return redirect()->route('invoice.detail', $no_invoice)
                         ->with('success', 'Nomor Order berhasil ditambahkan ke Invoice!');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REMOVE ORDER – hapus no_order dari detail_invoice
    // ─────────────────────────────────────────────────────────────────────────
    public function removeOrder(Request $request, string $no_invoice)
    {
        $request->validate(['no_order' => 'required|string|max:70']);

        DetailInvoice::where('no_invoice', $no_invoice)
                     ->where('no_order', $request->no_order)
                     ->delete();

        return redirect()->route('invoice.detail', $no_invoice)
                         ->with('success', 'Nomor Order berhasil dihapus dari Invoice!');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SAVE DPP
    // ─────────────────────────────────────────────────────────────────────────
    public function saveDpp(Request $request, string $no_invoice)
    {
        $request->validate(['dpp' => 'required|numeric']);

        Invoice::findOrFail($no_invoice)->update(['dpp' => $request->dpp]);

        return redirect()->route('invoice.detail', $no_invoice)
                         ->with('success', 'DPP berhasil disimpan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CETAK – halaman cetak invoice (A4, multi-page)
    // ─────────────────────────────────────────────────────────────────────────
    public function cetak(Request $request, string $no_invoice)
    {
        $invoice = Invoice::with('petugas')->findOrFail($no_invoice);

        $copy      = $request->query('copy', 'ori');
        $copyLabel = match ($copy) {
            'copy1' => 'COPY 1',
            'copy2' => 'COPY 2',
            'copy3' => 'COPY 3',
            default => 'ORI',
        };

        $linkedOrders = DetailInvoice::where('no_invoice', $no_invoice)
                                     ->orderBy('no_order')
                                     ->pluck('no_order')
                                     ->toArray();

        // Customer info
        $customerName    = '- (Belum ada Order)';
        $customerAddress = '-';
        if (!empty($linkedOrders)) {
            $cust = DB::table('purchase_order as po')
                ->join('customer as c', 'c.idcustomer', '=', 'po.idcustomer')
                ->whereIn('po.no_order', $linkedOrders)
                ->select('c.kepada_yth', 'c.alamat')
                ->first();
            if ($cust) {
                $customerName    = $cust->kepada_yth;
                $customerAddress = $cust->alamat;
            }
        }

        [$rows, $subKrg, $subPcs, $subKg, $subHarga] = $this->getDetailRows($linkedOrders);

        $grandTotal = $subHarga + $invoice->ppn + $invoice->dpp;
        $terbilang  = strtoupper(trim($this->terbilang($grandTotal))) . ' RUPIAH';

        // Pagination A4: maks 8 baris per halaman
        $limit  = 8;
        $chunks = !empty($rows) ? array_chunk($rows, $limit) : [[]];

        return view('invoice.cetak', compact(
            'invoice', 'copyLabel', 'linkedOrders',
            'customerName', 'customerAddress',
            'rows', 'chunks',
            'subKrg', 'subPcs', 'subKg', 'subHarga',
            'grandTotal', 'terbilang'
        ));
    }
}
