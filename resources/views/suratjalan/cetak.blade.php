{{-- resources/views/suratjalan/cetak.blade.php --}}
{{-- Halaman cetak mandiri (tanpa layout utama) --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Surat Jalan – PT. Yoko Fasteners Indonesia</title>
    <link rel="stylesheet" href="{{ asset('css/style-cetak.css') }}?v={{ time() }}" />
</head>

<body>

    <div class="no-print">
        <button class="btn-print btn-print-dataSj" onclick="window.print()">🖨 Cetak Surat Jalan</button>
        <button class="btn-print" onclick="window.location.href='{{ route('suratjalan.index') }}'">🔙 Kembali ke Daftar</button>
    </div>

    @php $totalPages = count($chunks); @endphp

    @foreach($chunks as $pageIdx => $chunkRows)
    @php
    $pageNum = $pageIdx + 1;
    $isLastPage = ($pageNum === $totalPages);
    @endphp

    <div class="page" id="surat-jalan">

        {{-- Header --}}
        <div class="header">
            <div class="logo-wrap">
                <img src="{{ asset('images/LogoTeks.png') }}" alt="Logo PT Yoko Fastener" />
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

        {{-- Judul --}}
        <div class="doc-title-wrap">
            <div class="doc-title">SURAT JALAN &nbsp;路单</div>
            <div class="doc-subtitle">No : {{ $dataSj->no_surat }}</div>
        </div>

        {{-- Meta --}}
        <div class="doc-meta">
            <div class="meta-left">
                <table>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td class="colon">:</td>
                        <td>{{ \Carbon\Carbon::parse($dataSj->tgl_surat)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding-top:8px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;"><strong>Kepada Yth</strong></td>
                        <td class="colon" style="vertical-align:top;">:</td>
                        <td>
                            <div class="addr-line"><strong>{{ $customerName }}</strong></div>
                            <div class="addr-line" style="max-width:250px;line-height:1.45;">
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
                    <th rowspan="2" style="width:15%">UKURAN</th>
                    <th rowspan="2" style="width:19%">UKURAN TAMU</th>
                    <th rowspan="2" style="width:6%">WRN</th>
                    <th rowspan="2" style="width:6%">JML<br>KRG</th>
                    <th rowspan="2" style="width:7%">PCS/<br>KRG</th>
                    <th rowspan="2" style="width:11%">TOTAL<br>(PCS)</th>
                    <th rowspan="2" style="width:7%">KG/<br>KRG</th>
                    <th rowspan="2" style="width:11%">TOTAL (KG)</th>
                    <th rowspan="2" style="width:13%">NO.<br>ORDER</th>
                </tr>
            </thead>
            <tbody>
                @if(empty($chunkRows))
                <tr>
                    <td colspan="9" style="text-align:center;font-style:italic;color:#666;height:50px;">
                        Belum ada data barang atau nomor order yang terhubung dengan surat jalan ini.
                    </td>
                </tr>
                @else
                @foreach($chunkRows as $row)
                <tr>
                    <td style="text-align:left;padding-left:5px;">{{ $row['ukuran'] }}</td>
                    <td style="text-align:left;padding-left:5px;">{{ $row['ukuran_tamu'] }}</td>
                    <td>{{ $row['wrn'] }}</td>
                    <td>{{ number_format($row['jmlh_krg'], 0, ',', '.') }}</td>
                    <td>{{ number_format($row['pcs_krg'], 0, ',', '.') }}</td>
                    <td>{{ number_format($row['total_pcs'], 0, ',', '.') }}</td>
                    <td>{{ number_format($row['kg_krg'], 0, ',', '.') }}</td>
                    <td>{{ number_format($row['total_kg'], 0, ',', '.') }}</td>
                    <td style="white-space:nowrap;">{{ $row['no_order'] }}</td>
                </tr>
                @endforeach
                @endif

                @if($isLastPage)
                <tr class="row-subtotal">
                    <td colspan="3" style="text-align:left;padding-left:8px;font-weight:700;">SUBTOTAL</td>
                    <td>{{ number_format($subTotalKrg, 0, ',', '.') }}</td>
                    <td></td>
                    <td><strong>{{ number_format($subTotalPcs, 0, ',', '.') }}</strong></td>
                    <td></td>
                    <td><strong>{{ number_format($subTotalKg, 0, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        @if($isLastPage)
        <div class="signature-row">
            <div class="sig-box">
                <div class="sig-label">PENERIMA</div>
                <div class="sig-name">&nbsp;</div>
            </div>
                <div class="sig-box">
                    <div class="sig-label">DRIVER</div>
                    <div class="sig-name">{{ $dataSj->driver->namapetugas ?? '-' }}</div>
                </div>
                <div class="sig-box">
                    <div class="sig-label">WAREHOUSE</div>
                    <div class="sig-name">{{ $dataSj->warehouse->namapetugas ?? '-' }}</div>
                </div>
                <div class="sig-box">
                    <div class="sig-label">DIBUAT</div>
                    <div class="sig-name">{{ $dataSj->admin->namapetugas ?? '-' }}</div>
                </div>
        </div>
        @else
        <div style="flex-grow:1;"></div>
        <div style="text-align:center;font-style:italic;color:#888;margin-top:15px;font-size:10px;letter-spacing:0.5px;">
            * Bersambung ke Halaman Berikutnya (Continued on Next Page) *
        </div>
        @endif

        {{-- Copy footer --}}
        <div class="copy-footer">
            <span class="copy-white">PUTIH = CUST/ACCT</span>
            <span class="copy-red">MERAH = GUDANG</span>
            <span class="copy-yellow">KUNING = CUST/ACCT</span>
            <span class="copy-green">HIJAU = ARSIP</span>
        </div>

        <div class="page-num">Halaman {{ $pageNum }} dari {{ $totalPages }}</div>

    </div>{{-- end .page --}}
    @endforeach

</body>

</html>