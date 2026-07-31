<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeVisit extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'tanggal',
        'nama_peserta_didik',
        'tindak_lanjut',
        'kasus',
        'solusi',
        'bukti_url',
        'dokumentasi_url'
    ];

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id');
    }
}
