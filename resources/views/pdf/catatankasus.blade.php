<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATATAN KASUS SISWA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            padding: 5px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
        th {
            background-color: #f2f2f2;
        }
        .info-table {
            width: 50%;
            margin-bottom: 10px;
        }
        .signature {
            margin-top: 30px;
            width: 100%;
            text-align: left;
        }
        .signature td, 
        .signature th {
        border: none !important;
        }
    </style>
</head>
<body>

    <div class="title">CATATAN KASUS SISWA</div>

    <table class="info-table">
        <tr>
            <td>Wali Kelas</td>
            <td>: {{ $walas->nama ?? '-' }}</td>
        </tr>
        <tr>
    <td>Tahun Pelajaran</td>
    <td>: {{ (date('n') >= 7 ? date('Y') : date('Y') - 1) . '/' . (date('n') >= 7 ? date('Y') + 1 : date('Y')) }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 20%;">Nama Siswa</th>
            <th style="width: 15%;">Tanggal & Waktu</th>
            <th style="width: 20%;">Kasus</th>
            <th style="width: 20%;">Tindak Lanjut / Sanksi</th>
            <th style="width: 20%;">Keterangan</th>
        </tr>
        @foreach ($catatankasus as $idx => $data)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td>{{ $data->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
                <td>
                    {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') : '-' }}
                    {{ $data->waktu ? \Carbon\Carbon::parse($data->waktu)->format('H:i') : '' }}
                </td>
                <td>{{ $data->kasus }}</td>
                <td>{{ $data->tindak_lanjut }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
