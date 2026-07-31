<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKbm extends Model
{
    use HasFactory;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'jadwal_kbms';
    protected $primaryKey = 'id';
    


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rombels_id',
        'walas_id',
        'kurikulum_id',
        'tanggal',
        'ttdkurikulum_url',
        'ttdwalas_url',
        'senin',
        'selasa',
        'rabu',
        'kamis',
        'jumat',
    ];

    /**
     * Cast JSON fields to array automatically.
     *
     * @var array
     */
    protected $casts = [
        'senin' => 'array',
        'selasa' => 'array',
        'rabu' => 'array',
        'kamis' => 'array',
        'jumat' => 'array',
    ];

    /**
     * Relationship with Walas.
     */
    public function walas()
    {
        return $this->belongsTo(Walas::class);
    }

    public function rombel()
{
    return $this->belongsTo(Rombel::class, 'rombels_id');
}

    /**
     * Relationship with Kurikulum.
     */
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
}
