<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Berita Acara Serah Terima Rapor</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; }
        h1 { font-size: 16px; margin: 0; } h2 { font-size: 14px; margin: 4px 0 0; }
        .content { margin-top: 30px; } .blank { border-bottom: 1px dotted #000; display: inline-block; min-width: 220px; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { border: 1px solid #000; padding: 7px; } th { text-align: center; }
        .signatures { border: 0; margin-top: 45px; } .signatures td { border: 0; width: 50%; text-align: center; }
        .space { height: 65px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK NEGERI 1 CIBINONG</h1>
        <h2>BERITA ACARA SERAH TERIMA RAPOR</h2>
    </div>
    <div class="content">
        <p>Pada hari ini, ................. tanggal ........................., telah dilaksanakan serah terima rapor peserta didik kelas <span class="blank">{{ $rombel->nama_kelas ?? '' }}</span>.</p>
        <p>Rapor diserahkan oleh wali kelas kepada orang tua/wali peserta didik sebagai dokumen hasil belajar.</p>
        <table>
            <thead><tr><th style="width: 8%;">No.</th><th>Nama Peserta Didik</th><th>Nama Orang Tua/Wali</th><th style="width: 18%;">Tanda Tangan</th></tr></thead>
            <tbody>
                @for ($i = 1; $i <= 10; $i++)
                    <tr><td style="text-align:center;">{{ $i }}</td><td>&nbsp;</td><td></td><td></td></tr>
                @endfor
            </tbody>
        </table>
        <p>Demikian berita acara ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>
    <table class="signatures">
        <tr>
            <td>Mengetahui,<br>Kepala Sekolah<div class="space"></div>(........................................)</td>
            <td>Cibinong, {{ now()->translatedFormat('d F Y') }}<br>Wali Kelas<div class="space"></div><strong>{{ $walas->nama ?? '(........................................)' }}</strong></td>
        </tr>
    </table>
</body>
</html>
