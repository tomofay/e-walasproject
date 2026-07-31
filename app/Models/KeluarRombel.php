<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeluarRombel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_siswa',
        'keterangan',
        'rombels_id'
    ];

    // Definisikan enum jika menggunakan enum type
    const KETERANGAN = [
        'naik_kelas' => 'Naik Kelas',
        'tidak_naik_kelas' => 'Tidak Naik Kelas',
        'pindah_sekolah' => 'Pindah Sekolah'
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombels_id', 'id');
    }

    // Relasi ke tabel Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nama_siswa', 'id');
    }

}

