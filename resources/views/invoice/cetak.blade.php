{{-- resources/views/invoice/cetak.blade.php --}}
{{-- Halaman cetak mandiri (tanpa layout utama) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Invoice – PT. Yoko Fasteners Indonesia</title>
    <link rel="stylesheet" href="{{ asset('css/style-cetak.css') }}?v={{ time() }}"/>
</head>
<body>

{{-- Tombol Print & Kembali --}}
<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨 Cetak Invoice</button>
    <button class="btn-print btn-print-sj" data-url="{{ route('invoice.index') }}" onclick="window.location.href=this.dataset.url">
        🔙 Kembali ke Daftar
    </button>
</div>

@php
    $totalPages = count($chunks);
@endphp

@foreach($chunks as $pageIdx => $chunkRows)
@php
    $pageNum    = $pageIdx + 1;
    $isLastPage = ($pageNum === $totalPages);
@endphp

<div class="page" id="invoice">

    {{-- Header --}}
    <div class="header">
        <div class="logo-wrap">
            <img src="{{ asset('images/LogoTeks.png') }}" alt="Logo PT Yoko Fastener"/>
        </div>
        <div class="company-info"> 
            <h1>PT. YOKO FASTENERS INDONESIA</h1>
            <div class="address">
                JL. KALISABI NO.99, RT.003/RW.011, KEL.UWUNG JAYA, KEC. CIBODAS<br>
                TANGERANG - BANTEN 15138
            </div>
        </div>
    </div>

    <div class="divider"></div>

    {{-- Judul Dokumen --}}
    <div class="doc-title-wrap">
        <div class="doc-title">INVOICE</div>
        <div class="doc-subtitle">No : {{ $invoice->no_invoice }}</div>
    </div>

    {{-- Meta --}}
    <div class="doc-meta">
        <div class="meta-left">
            <table>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td class="colon">:</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->tgl_invoice)->format('d-m-Y') }}</td>
                </tr>
                <tr><td colspan="3" style="padding-top:8px;"></td></tr>
                <tr>
                    <td style="vertical-align:top;"><strong>Kepada Yth</strong></td>
                    <td class="colon" style="vertical-align:top;">:</td>
                    <td>
                        <div class="addr-line"><strong>{{ $customerName }}</strong></div>
                        <div class="addr-line" style="max-width:380px; line-height:1.45;">
                            {!! nl2br(e($customerAddress)) !!}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="ori-badge">{{ $copyLabel }}</div>
    </div>

    {{-- Tabel Barang --}}
    <table class="form-table">
        <thead>
            <tr>
                <th rowspan="2" style="width:18%">UKURAN</th>
                <th rowspan="2" style="width:16%">UKURAN<br>TAMU</th>
                <th rowspan="2" style="width:4%">WRN</th>
                <th rowspan="2" style="width:5%">JML<br>KRG</th>
                <th rowspan="2" style="width:6%">PCS/<br>KRG</th>
                <th rowspan="2" style="width:10%">TOTAL<br>(PCS)</th>
                <th rowspan="2" style="width:5%">KG/<br>KRG</th>
                <th rowspan="2" style="width:6%">TOTAL<br>(KG)</th>
                <th rowspan="2" style="width:10%">HARGA</th>
                <th rowspan="2" style="width:11%">JUMLH HARGA</th>
                <th rowspan="2" style="width:9%">NO.<br>ORDER</th>
            </tr>
        </thead>
        <tbody>
            @if(empty($chunkRows))
                <tr>
                    <td colspan="11" style="text-align:center; font-style:italic; color:#666; height:50px;">
                        Belum ada data barang atau nomor order yang terhubung dengan invoice ini.
                    </td>
                </tr>
            @else
                @foreach($chunkRows as $row)
                <tr>
                    <td style="text-align:left; padding-left:5px;">{{ $row->ukuran }}</td>
                    <td style="text-align:left; padding-left:5px;">{{ $row->ukuran_tamu }}</td>
                    <td>{{ $row->wrn }}</td>
                    <td>{{ number_format($row->jmlh_krg, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->pcs_krg, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->total_pcs, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->kg_krg, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->total_kg, 0, ',', '.') }}</td>
                    <td class="rp-cell">
                        <div class="rp-wrapper">
                            <span>Rp</span><span>{{ number_format($row->harga, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="rp-cell">
                        <div class="rp-wrapper">
                            <span>Rp</span><span>{{ number_format($row->jumlah_harga, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td style="white-space:nowrap;">{{ $row->no_order }}</td>
                </tr>
                @endforeach
            @endif

            @if($isLastPage)
            {{-- Subtotal --}}
            <tr class="row-subtotal">
                <td colspan="3" style="text-align:left; padding-left:8px;">SUBTOTAL</td>
                <td>{{ number_format($subKrg, 0, ',', '.') }}</td>
                <td></td>
                <td><strong>{{ number_format($subPcs, 0, ',', '.') }}</strong></td>
                <td></td>
                <td><strong>{{ number_format($subKg, 0, ',', '.') }}</strong></td>
                <td></td>
                <td class="rp-cell">
                    <div class="rp-wrapper">
                        <span>Rp</span><strong>{{ number_format($subHarga, 0, ',', '.') }}</strong>
                    </div>
                </td>
                <td></td>
            </tr>

            {{-- DPP --}}
            <tr class="row-summary">
                <td colspan="9" class="label-cell">DPP NILAI LAIN</td>
                <td class="rp-cell">
                    <div class="rp-wrapper">
                        <span>Rp</span><span>{{ number_format($invoice->dpp, 0, ',', '.') }}</span>
                    </div>
                </td>
                <td></td>
            </tr>

            {{-- PPN 12% --}}
            <tr class="row-summary">
                <td colspan="9" class="label-cell">PPN 12%</td>
                <td class="rp-cell">
                    <div class="rp-wrapper">
                        <span>Rp</span><span>{{ number_format($invoice->ppn, 0, ',', '.') }}</span>
                    </div>
                </td>
                <td></td>
            </tr>

            {{-- Total --}}
            <tr class="row-subtotal">
                <td colspan="9" style="text-align:left; padding-left:8px;">TOTAL</td>
                <td class="rp-cell">
                    <div class="rp-wrapper">
                        <span>Rp</span><strong>{{ number_format($grandTotal, 0, ',', '.') }}</strong>
                    </div>
                </td>
                <td></td>
            </tr>

            {{-- Terbilang --}}
            <tr>
                <td colspan="11"
                    style="text-align:left; padding:6px 10px; border-top:1px solid #ccc; background:#fafafa;">
                    <div style="font-size:8px; font-weight:700; color:#555; margin-bottom:2px;">TERBILANG:</div>
                    <div class="terbilang-dots">{{ $terbilang }}</div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    @if($isLastPage)
    <div class="signature-row-invoice">
        <div class="payment-box">
            <div class="pay-title">Pembayaran Rekening :</div>
            BCA KCP Plaza Merdeka Mas<br>
            A/C No. 7134377888<br>
            a.n. PT YOKO FASTENERS INDONESIA
        </div>
        <div class="sig-col" style="width:130px;">
            <div class="sig-label">PENERIMA</div>
            <div class="sig-name">&nbsp;</div>
        </div>
        <div class="sig-col" style="width:130px;">
            <div class="sig-label">HORMAT KAMI</div>
            <div class="sig-name">{{ $invoice->petugas->namapetugas ?? '-' }}</div>
        </div>
    </div>
    @else
    <div style="flex-grow:1;"></div>
    <div style="text-align:center; font-style:italic; color:#888; margin-top:15px; font-size:10px; letter-spacing:0.5px;">
        * Bersambung ke Halaman Berikutnya (Continued on Next Page) *
    </div>
    @endif

    <div class="page-num">Halaman {{ $pageNum }} dari {{ $totalPages }}</div>

</div>{{-- end .page --}}
@endforeach

</body>
</html>
