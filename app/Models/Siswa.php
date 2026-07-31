<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'siswas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'rombels_id',
        'jenis_kelamin',
        'no_wa',
        'password',
        'image_url',
        'status'
    ];
    protected $hidden = ['password'];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombels_id', 'id');
    }

    public function kelompok()
    {
        return $this->belongsToMany(DenahTempatKerjaKelompok::class, 'kelompok_siswa', 'siswa_id', 'kelompok_id');
    }

    public function biodata()
    {
        return $this->hasOne(BiodataSiswa::class, 'siswas_id', 'id');
    }

    public function daftarPesertaDidik()
    {
        return $this->hasMany(DaftarPesertaDidik::class, 'nama_siswa', 'id');
    }

    public function detailPresensis()
    {
        return $this->hasMany(DetailPresensi::class, 'siswas_id');
    }

    public function keluarRombel()
    {
        return $this->hasOne(KeluarRombel::class, 'siswa_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($siswa) {
            if ($siswa->status == 'nonaktif') {
                Alumni::create([
                    'siswa_id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'no_wa' => $siswa->no_wa,
                    'rombels_id' => $siswa->rombels_id,
                ]);

                $siswa->delete();
            }
        });
    }
}
