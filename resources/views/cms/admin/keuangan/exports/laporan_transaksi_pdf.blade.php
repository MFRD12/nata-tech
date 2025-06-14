<head>
    <meta charset="UTF-8" />
    <title>Laporan Transaksi</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            /* lebih kecil */
            color: #2c3e50;
            margin: 30px 40px;
            /* margin lebih kecil */
            background: #fff;
            line-height: 1.4;
        }

        header {
            border-bottom: 2px solid #2980b9;
            padding-bottom: 8px;
            margin-bottom: 25px;
        }

        header h1 {
            font-weight: 700;
            font-size: 20px;
            /* lebih kecil */
            color: #2980b9;
            margin: 0;
        }

        header p {
            margin-top: 3px;
            font-size: 12px;
            color: #7f8c8d;
        }

        .filters {
            border: 1px solid #2980b9;
            border-radius: 5px;
            margin-bottom: 25px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgb(41 128 185 / 0.15);
        }

        .filters table {
            width: 100%;
            border-collapse: collapse;
        }

        .filters td {
            padding: 6px 10px;
        }

        .filters .key {
            background-color: #2980b9;
            color: white;
            font-weight: 600;
            width: 30%;
            border-right: 1px solid #1c5980;
        }

        .filters .value {
            background-color: #d6eaff;
            color: #154360;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            font-size: 11px;
            /* font kecil */
        }

        th,
        td {
            padding: 8px 10px;
            /* padding dikurangi */
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background-color: #2980b9;
            color: white;
            font-weight: 700;
            text-align: left;
            letter-spacing: 0.03em;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fbfd;
        }

        tbody tr:hover {
            background-color: #dbeeff;
        }

        tfoot tr th {
            background-color: #154360;
            color: #ecf0f1;
            font-size: 12px;
            text-align: right;
        }

        tfoot tr th[colspan="4"] {
            text-align: right;
        }

        tfoot tr th[colspan="2"] {
            text-align: right;
            font-weight: 700;
        }

        .text-right {
            text-align: right;
        }

        footer {
            margin-top: 35px;
            padding-top: 12px;
            border-top: 2px solid #2980b9;
            font-size: 10px;
            color: #7f8c8d;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h1>Laporan Transaksi</h1>
        <p>Waktu Ekspor: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d M Y H:i:s') }}</p>
    </header>

    @if (!empty($filters))
        <section class="filters" aria-label="Filter Transaksi">
            <table role="presentation">
                <tbody>
                    @foreach ($filters as $key => $value)
                        @if (!empty($value))
                            <tr>
                                <td class="key">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="value">
                                    @if (in_array($key, ['bulan_awal', 'bulan_akhir']))
                                        {{ \Carbon\Carbon::create()->month((int)$value)->locale('id')->translatedFormat('F') }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </section>
    @endif

    <main>
        <table role="table" aria-label="Daftar Transaksi">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 35%;">Nama Transaksi</th>
                    <th style="width: 20%;">Kategori</th>
                    <th style="width: 18%; text-align: left;">Pemasukan (Rp)</th>
                    <th style="width: 18%; text-align: left;">Pengeluaran (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                        <td>{{ $transaksi->nama_transaksi }}</td>
                        <td>{{ $transaksi->kategori->name ?? '-' }}</td>
                        <td class="text-right">
                            {{ $transaksi->kategori->jenis == 'pemasukan' ? '' . number_format($transaksi->jumlah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $transaksi->kategori->jenis == 'pengeluaran' ? '' . number_format($transaksi->jumlah, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total (Rp)</th>
                    <th class="text-right">{{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                    <th class="text-right">{{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <th colspan="4">Saldo Akhir (Rp)</th>
                    <th colspan="2" class="text-center">{{ number_format($saldoAkhir, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </main>

    <footer>
        &copy; {{ date('Y') }} PT Naraya Satya Teknologi Utama - Semua Hak Dilindungi
    </footer>
</body>
