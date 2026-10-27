<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lembar Pengesahan Wali Kelas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; }
        h1 { font-size: 16px; margin: 0; } h2 { font-size: 14px; margin: 4px 0 0; }
        .content { margin-top: 35px; } .line { border-bottom: 1px dotted #000; display: inline-block; min-width: 260px; }
        .signatures { margin-top: 70px; width: 100%; border-collapse: collapse; }
        .signatures td { width: 50%; text-align: center; vertical-align: top; }
        .space { height: 70px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK NEGERI 1 CIBINONG</h1>
        <h2>LEMBAR PENGESAHAN WALI KELAS</h2>
    </div>
    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa dokumen administrasi wali kelas berikut telah diperiksa dan disahkan:</p>
        <p>Nama Wali Kelas : <span class="line">{{ $walas->nama ?? '' }}</span></p>
        <p>Kelas : <span class="line">{{ $rombel->nama_kelas ?? '' }}</span></p>
        <p>Tahun Pelajaran : <span class="line">{{ now()->year }}/{{ now()->year + 1 }}</span></p>
        <p>Demikian lembar pengesahan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>
    <table class="signatures">
        <tr>
            <td>Mengetahui,<br>Kepala Sekolah<div class="space"></div>(........................................)</td>
            <td>Cibinong, {{ now()->translatedFormat('d F Y') }}<br>Wali Kelas<div class="space"></div><strong>{{ $walas->nama ?? '(........................................)' }}</strong></td>
        </tr>
    </table>
</body>
</html>
