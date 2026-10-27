<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class KeluarRombel extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'keterangan',
        'rombels_id',
        'academic_year',
        'semester',
    ];

    public static function availableAcademicPeriods(): Collection
    {
        return static::query()
            ->select(['academic_year', 'semester'])
            ->selectRaw('COUNT(*) as record_count')
            ->whereNotNull('academic_year')
            ->whereNotNull('semester')
            ->groupBy('academic_year', 'semester')
            ->orderByDesc('academic_year')
            ->orderBy('semester')
            ->get();
    }

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
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

}
