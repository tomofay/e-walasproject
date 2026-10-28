<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta Didik</title>
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

    <div class="title">DAFTAR PESERTA DIDIK</div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th>NISN</th>
            <th>Jenis Kelamin</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
        </tr>
        @foreach ($daftarPDidik as $idx => $data)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $data->siswa->nama ?? '-' }}</td>
                <td>{{ $data->nis ?: ($data->siswa->biodata?->nis ?? '-') }}</td>
                <td>{{ $data->nisn ?: ($data->siswa->biodata?->nisn ?? '-') }}</td>
                <td>{{ $data->jenis_kelamin ?? ($data->siswa->jenis_kelamin ?? '-') }}</td>
                <td>{{ ucfirst($data->keterangan ?? ($data->siswa->status ?? 'Aktif')) }}</td>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </table>

    <table class="info-table">
        <tr>
            <td>Jumlah Laki-laki</td>
            <td>: {{ $jenisKelaminCount['Laki-laki'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Jumlah Perempuan</td>
            <td>: {{ $jenisKelaminCount['Perempuan'] ?? 0 }}</td>
        </tr>
    </table>

    @php
        $wakaKurikulum = \App\Models\Kurikulum::first(); // Ambil satu data Waka Kurikulum
        \Carbon\Carbon::setLocale('id');
    @endphp

    <div class="signature">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="text-align: center;">Mengetahui,</td>
                <td></td>
                <td style="text-align: center;">Cibinong, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">Waka. Bidang Akademik,</td>
                <td></td>
                <td style="text-align: center;">Wali Kelas,</td>
            </tr>
            <tr><td colspan="3"><br><br><br></td></tr>
            <tr>
                <td style="text-align: center;">({{ optional($wakaKurikulum)->nama ?? '_________________' }})</td>
                <td></td>
                <td style="text-align: center;">({{ optional($walasList->where('id', $walasIdSelected)->first())->nama ?? '_________________' }})</td>
            </tr>
            <tr>
                <td style="text-align: center;">NIP  {{ optional($wakaKurikulum)->nip ?? '......................' }}</td>
                <td></td>
                <td style="text-align: center;">NIP  {{ optional($walasList->where('id', $walasIdSelected)->first())->nip ?? '......................' }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
