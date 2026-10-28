<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DAFTAR HADIR SISWA - PEMBINA SISWA</title>
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
            background-color: #047857;
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

    <div class="header-title">REKAPITULASI DAFTAR HADIR SISWA - SMKN 1 CIBINONG</div>

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
                <th style="width: 25%;">Wali Kelas</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 10%;">Hadir</th>
                <th style="width: 10%;">Sakit</th>
                <th style="width: 10%;">Izin</th>
                <th style="width: 10%;">Alfa</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($presensis as $idx => $p)
                @php
                    $hadir = $p->detailPresensis->where('status', 'hadir')->count();
                    $sakit = $p->detailPresensis->where('status', 'sakit')->count();
                    $izin  = $p->detailPresensis->where('status', 'izin')->count();
                    $alfa  = $p->detailPresensis->where('status', 'alfa')->count();
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td style="text-align: center;"><strong>{{ $p->kelas }}</strong></td>
                    <td>{{ $p->walas->nama ?? '-' }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                    <td style="text-align: center; color: #047857; font-weight: bold;">{{ $hadir }}</td>
                    <td style="text-align: center; color: #b45309; font-weight: bold;">{{ $sakit }}</td>
                    <td style="text-align: center; color: #0369a1; font-weight: bold;">{{ $izin }}</td>
                    <td style="text-align: center; color: #b91c1c; font-weight: bold;">{{ $alfa }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 15px;">Tidak ada data rekapan presensi.</td>
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
