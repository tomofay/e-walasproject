<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CATATAN KASUS SISWA - PEMBINA SISWA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            background-color: #1e40af;
            color: white;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #94a3b8;
            padding: 6px;
            font-size: 11px;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-align: center;
        }
        .info-table {
            width: 60%;
            margin-bottom: 12px;
        }
        .info-table td {
            border: none;
            padding: 3px;
        }
        .signature-table {
            margin-top: 25px;
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            padding: 5px;
        }
    </style>
</head>
<body>

    <div class="header-title">REKAPITULASI CATATAN KASUS SISWA - SMKN 1 CIBINONG</div>

    <table class="info-table">
        <tr>
            <td style="width: 120px;"><strong>Pembina Siswa</strong></td>
            <td>: {{ $pembina->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIP</strong></td>
            <td>: {{ $pembina->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak</strong></td>
            <td>: {{ date('d F Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kelas</th>
                <th style="width: 20%;">Nama Siswa</th>
                <th style="width: 15%;">Waktu</th>
                <th style="width: 20%;">Uraian Kasus</th>
                <th style="width: 25%;">Tindak Lanjut & Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($catatankasus as $idx => $data)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td style="text-align: center;">{{ $data->siswa->rombel->nama_kelas ?? '-' }}</td>
                    <td><strong>{{ $data->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</strong></td>
                    <td style="text-align: center;">
                        {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') : '-' }}<br>
                        <small>{{ $data->waktu ? \Carbon\Carbon::parse($data->waktu)->format('H:i') : '' }}</small>
                    </td>
                    <td>{{ $data->kasus }}</td>
                    <td>
                        <strong>Tindak Lanjut:</strong> {{ $data->tindak_lanjut }}
                        @if($data->keterangan)
                            <br><small><strong>Ket:</strong> {{ $data->keterangan }}</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 15px;">Tidak ada data catatan kasus siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: center;">
                Cibinong, {{ date('d F Y') }}<br>
                Pembina Siswa,<br><br><br><br>
                <strong><u>{{ $pembina->nama }}</u></strong><br>
                NIP. {{ $pembina->nip ?? '-' }}
            </td>
        </tr>
    </table>

</body>
</html>
