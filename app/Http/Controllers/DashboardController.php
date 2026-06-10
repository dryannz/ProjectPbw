<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        // ── STAT COUNTS ──
        $stats = [
            'total_po'       => DB::table('purchase_order')->count(),
            'total_invoice'  => DB::table('invoice')->count(),
            'total_sj'       => DB::table('surat_jalan')->count(),
            'total_customer' => DB::table('customer')->count(),
            'total_barang'   => DB::table('barang')->count(),
            'total_petugas'  => DB::table('petugas')->count(),
        ];

        // ── 5 PO TERBARU + STATUS ──
        $latestPO = DB::select("
            SELECT
                po.no_order,
                c.kepada_yth,
                po.tgl_order,
                po.schedule_delivery,
                CASE
                    WHEN COUNT(sj.no_invoice) > 0 THEN 'Selesai'
                    WHEN COUNT(di.no_invoice) > 0 THEN 'Proses'
                    ELSE 'Baru'
                END AS status_po
            FROM purchase_order po
            LEFT JOIN customer c         ON po.idcustomer  = c.idcustomer
            LEFT JOIN detail_invoice di  ON po.no_order    = di.no_order
            LEFT JOIN surat_jalan sj     ON di.no_invoice  = sj.no_invoice
            GROUP BY po.no_order, c.kepada_yth, po.tgl_order, po.schedule_delivery
            ORDER BY po.no_order DESC
            LIMIT 5
        ");

        // ── 5 INVOICE TERBARU ──
        $latestInvoice = DB::select("
            SELECT
                i.no_invoice,
                i.tgl_invoice,
                COALESCE(SUM(dp.jumlah_harga), 0) AS total,
                GROUP_CONCAT(DISTINCT di.no_order ORDER BY di.no_order ASC SEPARATOR ', ') AS semua_no_order
            FROM invoice i
            LEFT JOIN detail_invoice di ON di.no_invoice = i.no_invoice
            LEFT JOIN detail_po dp      ON di.no_order   = dp.no_order
            GROUP BY i.no_invoice, i.tgl_invoice
            ORDER BY i.no_invoice DESC
            LIMIT 5
        ");

        // ── 5 SURAT JALAN TERBARU ──
        $latestSuratJalan = DB::select("
            SELECT
                s.no_surat,
                s.tgl_surat,
                COALESCE(SUM(dp.jumlah_harga), 0) AS subtotal,
                GROUP_CONCAT(DISTINCT i.no_order ORDER BY i.no_order ASC SEPARATOR ', ') AS semua_no_order
            FROM surat_jalan s
            LEFT JOIN detail_surat_jalan dsj ON s.no_surat    = dsj.no_surat
            LEFT JOIN invoice i              ON dsj.no_invoice = i.no_invoice
            LEFT JOIN detail_po dp           ON i.no_order     = dp.no_order
            GROUP BY s.no_surat, s.tgl_surat
            ORDER BY s.no_surat DESC
            LIMIT 5
        ");

        // ── CHART: jumlah PO per bulan (6 bulan terakhir) ──
        $chartData = DB::select("
            SELECT
                DATE_FORMAT(tgl_order, '%b')   AS bulan,
                DATE_FORMAT(tgl_order, '%Y-%m') AS ym,
                COUNT(*) AS jumlah
            FROM purchase_order
            WHERE tgl_order >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY ym, bulan
            ORDER BY ym ASC
            LIMIT 6
        ");

        $chartLabels = collect($chartData)->pluck('bulan')->toArray();
        $chartVals   = collect($chartData)->pluck('jumlah')->map(fn($v) => (int) $v)->toArray();

        if (empty($chartVals)) {
            $chartLabels = ['—'];
            $chartVals   = [0];
        }

        $chartMax = max($chartVals) ?: 1;

        return view('dashboard.index', compact(
            'stats',
            'latestPO',
            'latestInvoice',
            'latestSuratJalan',
            'chartLabels',
            'chartVals',
            'chartMax'
        ));
    }
}
