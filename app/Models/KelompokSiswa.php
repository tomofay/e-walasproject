<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelompokSiswa extends Model
{
    use HasFactory;
    protected $table = 'kelompok_siswa';
    protected $fillable = [
        'id',
        'kelompok_id',
        'siswa_id'
    ];
}
