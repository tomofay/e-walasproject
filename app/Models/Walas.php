<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Walas extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'no_wa',
        'password',
        'nip',
        'image_url'
    ];
    protected $hidden = ['password'];

    public function rombel()
    {
        return $this->hasOne(Rombel::class, 'walas_id');
    }

    public function biodata()
    {
        return $this->hasMany(BiodataSiswa::class, 'walas_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'walas_id');
    }

    public function agendaKegiatan()
    {
        return $this->hasMany(AgendaKegiatanWalas::class, 'walas_id');
    }

    public function catatanKasus()
    {
        return $this->hasMany(CatatanKasusSiswa::class, 'walas_id');
    }

    public function homeVisit()
    {
        return $this->hasMany(HomeVisit::class, 'walas_id');
    }

    public function bukuTamuOrangtua()
    {
        return $this->hasMany(BukuTamuOrangtua::class, 'walas_id');
    }

    public function rencanaKegiatan()
    {
        return $this->hasMany(RencanaKegiatanWalas::class, 'walas_id');
    }

    public function identitasKelas()
    {
        return $this->hasOne(IdentitasKelas::class, 'walas_id');
    }
}
