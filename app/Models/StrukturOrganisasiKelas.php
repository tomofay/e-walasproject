<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrukturOrganisasiKelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'kepala_sekolah',
        'walas',
        'ketuakelas',
        'waketuakelas',
        'bendahara',
        'sekretaris',
        'seksi_kebersihan',
        'seksi_perlengkapan',
        'seksi_keamanan',
        'seksi_kerohanian',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
    ];

    public function ketuaKelas()
    {
        return $this->belongsTo(Siswa::class, 'ketuakelas');
    }

    public function wakilKetuaKelas()
    {
        return $this->belongsTo(Siswa::class, 'waketuakelas');
    }

    public function bendaharaSiswa()
    {
        return $this->belongsTo(Siswa::class, 'bendahara');
    }

    public function sekretarisSiswa()
    {
        return $this->belongsTo(Siswa::class, 'sekretaris');
    }

    public function seksiKebersihan()
    {
        return $this->belongsTo(Siswa::class, 'seksi_kebersihan');
    }

    public function seksiPerlengkapan()
    {
        return $this->belongsTo(Siswa::class, 'seksi_perlengkapan');
    }

    public function seksiKeamanan()
    {
        return $this->belongsTo(Siswa::class, 'seksi_keamanan');
    }

    public function seksiKerohanian()
    {
        return $this->belongsTo(Siswa::class, 'seksi_kerohanian');
    }
}
