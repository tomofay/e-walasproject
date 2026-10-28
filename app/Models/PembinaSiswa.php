<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PembinaSiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'pembina_siswas';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'nip',
        'no_wa',
        'password',
        'image_url',
    ];

    protected $hidden = [
        'password',
    ];
}
