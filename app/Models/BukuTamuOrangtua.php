<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BukuTamuOrangtua extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'tanggal',
        'nama_peserta_didik',
        'nama_orang_tua',
        'tindak_lanjut',
        'kasus',
        'solusi',
        'dokumentasi_url'
    ];

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id');
    }
}
