<table>
    <thead>
        <tr>
            <th colspan="6"
                style="font-size:18px; font-weight:bold; text-align:center; background-color:#2563eb; color:white;">
                Laporan Transaksi
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align:right; font-style:italic; font-weight:bold; background-color:#bfdbfe;">
                Di Ekspor: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d M Y H:i:s') }}
            </th>
        </tr>
        @if (!empty($filters))
            @foreach ($filters as $key => $value)
                @if (!empty($value))
                    <tr>
                        <td colspan="6" style="text-align:left; font-weight:bold; background-color:#e0e7ff;">
                            {{ ucfirst(str_replace('_', ' ', $key)) }}:
                            @if (in_array($key, ['bulan_awal', 'bulan_akhir']))
                               {{ \Carbon\Carbon::create()->month((int)$value)->locale('id')->translatedFormat('F') }}
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif

        <tr style="font-weight:bold; background-color:#2563eb; color:white; font-size:14px; text-align:center;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Transaksi</th>
            <th>Kategori</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksis as $index => $transaksi)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td style="text-align:center;">{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                <td>{{ $transaksi->nama_transaksi }}</td>
                <td>{{ $transaksi->kategori->name ?? '-' }}</td>
                <td style="text-align:right; color:#16a34a; font-weight:bold;">
                    {{ $transaksi->kategori->jenis === 'pemasukan' ? 'Rp ' . number_format($transaksi->jumlah, 0, ',', '.') : '' }}
                </td>
                <td style="text-align:right; color:#dc2626; font-weight:bold;">
                    {{ $transaksi->kategori->jenis === 'pengeluaran' ? 'Rp ' . number_format($transaksi->jumlah, 0, ',', '.') : '' }}
                </td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background-color:#d1fae5; color:#16a34a;">
            <td colspan="4" style="text-align:right;">Total Pemasukan</td>
            <td style="text-align:right;">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr style="font-weight:bold; background-color:#fee2e2;  color:#dc2626;">
            <td colspan="4" style="text-align:right;">Total Pengeluaran</td>
            <td></td>
            <td style="text-align:right;">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr style="font-weight:bold; background-color:#bfdbfe; color:#1e40af;">
            <td colspan="4" style="text-align:right;">Saldo Akhir</td>
            <td colspan="2" style="text-align:right;">{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
