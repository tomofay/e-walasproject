<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Visit Report</title>
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
        .img-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="title">LAPORAN HOME VISIT</div>

    <table class="info-table">
        <tr>
            <td>Wali Kelas</td>
            <td>: {{ $walas->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $rombel->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
    <td>Tahun Pelajaran</td>
    <td>: {{ (date('n') >= 7 ? date('Y') : date('Y') - 1) . '/' . (date('n') >= 7 ? date('Y') + 1 : date('Y')) }}</td>
        </tr>
    </table>

    <table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Peserta Didik</th>
        <th>Keperluan</th>
        <th>Solusi</th>
        <th>Tindak Lanjut</th>
        <th>Foto Surat</th>
        <th>Dokumentasi</th>
    </tr>
    @foreach($homevisit as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->siswa?->nama ?? $item->nama_peserta_didik }}</td>
            <td>{{ $item->kasus }}</td>
            <td>{{ $item->solusi }}</td>
            <td>{{ $item->tindak_lanjut }}</td>
            <td>
    @if($item->bukti_base64)
        <img src="{{ $item->bukti_base64 }}" style="width: 100%; max-width: 200px;">
    @else
        <p>No image</p>
    @endif
</td>

<td>
    @if($item->dokumentasi_base64)
        <img src="{{ $item->dokumentasi_base64 }}" style="width: 100%; max-width: 200px;">
    @else
        <p>No image</p>
    @endif
</td>
        </tr>
    @endforeach
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
                <td style="text-align: center;">({{ optional($walas)->nama ?? '_________________' }})</td>
            </tr>
            <tr>
                <td style="text-align: center;">NIP  {{ optional($wakaKurikulum)->nip ?? '......................' }}</td>
                <td></td>
                <td style="text-align: center;">NIP  {{ optional($walas)->nip ?? '......................' }}</td>
            </tr>
        </table>
    </div>

</body>
</html>