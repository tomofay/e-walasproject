<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rombel extends Model
{
    use HasFactory;
    protected $fillable = [
        'tingkat',
        'kompetensi',
        'nama_kelas',
        'walas_id'
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'rombels_id', 'id');
    }

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id', 'id'); // walas_id adalah foreign key
    }

}
