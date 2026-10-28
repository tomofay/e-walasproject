<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PrestasiSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'walas_id',
        'siswas_id', 
        'rombels_id', 
        'jenis_prestasi',
        'nama_prestasi',
        'nama_pembimbing',
        'mata_lomba',
        'tingkat',
        'lokasi',
        'tanggal',
        'sertifikat_url',
        'dokumentasi_url',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Accessor & Mutator for dokumentasi_url to handle array of uploaded photos.
     */
    protected function dokumentasiUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (empty($value)) {
                    return [];
                }
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }
                return is_string($value) ? [$value] : (array) $value;
            },
            set: function ($value) {
                if (empty($value)) {
                    return null;
                }
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return $value;
                    }
                    return json_encode([$value]);
                }
                $filtered = array_values(array_filter((array) $value));
                return empty($filtered) ? null : json_encode($filtered);
            }
        );
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id', 'id');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombels_id', 'id');
    }

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id', 'id');
    }
}
