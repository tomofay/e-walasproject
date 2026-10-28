<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 2;
            margin: 30px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: white;
            background-color: #2671eb;
            padding: 10px;
            line-height: 1;
        }
        .content {
            font-size: 11px;
        }
        .content .label {
            width: 200px;
            display: inline-block;
        }
        .content .dots {
            border-bottom: 1px dotted black;
            width: 300px;
            display: inline-block;
        }
        .section-title {
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="title">Biodata Siswa</div>
    <div class="content">
        <div><span class="label">Nama</span>: <span class="dots">{{ $biodatas->nama_lengkap }}</span></div>
        <div><span class="label">Jenis Kelamin</span>: <span class="dots">{{ $biodatas->jenis_kelamin }}</span></div>
        <div><span class="label">Tempat, Tanggal Lahir</span>: <span class="dots">{{ $biodatas->tempat_lahir }}, {{ $biodatas->tanggal_lahir }}</span></div>
        <div><span class="label">Alamat</span>: <span class="dots">{{ $biodatas->alamat }}</span></div>
        <div><span class="label">Jalur Masuk</span>: <span class="dots">{{ $biodatas->jalur_masuk }}</span></div>
        <div><span class="label">Jarak Rumah</span>: <span class="dots">{{ $biodatas->jarak_rumah }}</span></div>
        <div><span class="label">Transportasi Sekolah</span>: <span class="dots">{{ $biodatas->transportasi_sekolah }}</span></div>
        <div><span class="label">Transportasi Rumah</span>: <span class="dots">{{ $biodatas->transportasi_rumah }}</span></div>
        <div><span class="label">Agama</span>: <span class="dots">{{ $biodatas->agama }}</span></div>
        <div><span class="label">Kewarganegaraan</span>: <span class="dots">{{ $biodatas->kewarganegaraan }}</span></div>
        <div><span class="label">Anak Ke</span>: <span class="dots">{{ $biodatas->anak_ke }}</span></div>
        <div><span class="label">Jumlah Saudara</span>: <span class="dots">{{ $biodatas->jumlah_saudara }}</span></div>
        <div><span class="label">No WA</span>: <span class="dots">{{ $biodatas->no_wa }}</span></div>
        <div><span class="label">Email</span>: <span class="dots">{{ $biodatas->email }}</span></div>
        <div><span class="label">NIS</span>: <span class="dots">{{ $biodatas->nis }}</span></div>
        <div><span class="label">NISN</span>: <span class="dots">{{ $biodatas->nisn }}</span></div>
        <div><span class="label">Kelas</span>: <span class="dots">{{ $biodatas->kelas }}</span></div>
        <div><span class="label">Kompetensi</span>: <span class="dots">{{ $biodatas->kompetensi }}</span></div>
        <div><span class="label">Tahun Masuk</span>: <span class="dots">{{ $biodatas->tahun_masuk }}</span></div>

        <div class="section-title">Data Orang Tua/Wali</div>
        <div><span class="label">Nama Ayah</span>: <span class="dots">{{ $biodatas->nama_ayah }}</span></div>
        <div><span class="label">Pekerjaan Ayah</span>: <span class="dots">{{ $biodatas->pekerjaan_ayah }}</span></div>
        <div><span class="label">No WA Ayah</span>: <span class="dots">{{ $biodatas->no_wa_ayah }}</span></div>
        <div><span class="label">Nama Ibu</span>: <span class="dots">{{ $biodatas->nama_ibu }}</span></div>
        <div><span class="label">Pekerjaan Ibu</span>: <span class="dots">{{ $biodatas->pekerjaan_ibu }}</span></div>
        <div><span class="label">No WA Ibu</span>: <span class="dots">{{ $biodatas->no_wa_ibu }}</span></div>
        <div><span class="label">Pendapatan Orang Tua</span>: <span class="dots">{{ $biodatas->pendapatan_ortu }}</span></div>
        
        <div class="section-title">Data Sekolah Asal</div>
        <div><span class="label">Nama Sekolah Asal</span>: <span class="dots">{{ $biodatas->namasekolah_asal }}</span></div>
        <div><span class="label">Alamat Sekolah</span>: <span class="dots">{{ $biodatas->alamat_sekolah }}</span></div>
        <div><span class="label">Tahun Lulus</span>: <span class="dots">{{ $biodatas->tahun_lulus }}</span></div>
        
        <div class="section-title">Riwayat Kesehatan</div>
        <div><span class="label">Riwayat Penyakit</span>: <span class="dots">{{ $biodatas->riwayat_penyakit }}</span></div>
        <div><span class="label">Alergi</span>: <span class="dots">{{ $biodatas->alergi }}</span></div>
        
        <div class="section-title">Prestasi dan Pengalaman</div>
        <div><span class="label">Prestasi Akademik</span>: <span class="dots">{{ $biodatas->prestasi_akademik }}</span></div>
        <div><span class="label">Prestasi Non-Akademik</span>: <span class="dots">{{ $biodatas->prestasi_non_akademik }}</span></div>
        <div><span class="label">Pengalaman Ekstrakurikuler</span>: <span class="dots">{{ $biodatas->pengalaman_ekskul }}</span></div>
        <div><span class="label">Kepribadian</span>: <span class="dots">{{ $biodatas->Kepribadian }}</span></div>
    </div>
</body>

</html>
