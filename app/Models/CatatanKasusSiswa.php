<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CatatanKasusSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'walas_id',
        'siswas_id',
        'tanggal',
        'waktu',
        'kasus',
        'tindak_lanjut',
        'keterangan',
        'file_kasus',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Accessor & Mutator for file_kasus to handle array of uploaded files seamlessly.
     */
    protected function fileKasus(): Attribute
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

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'walas_id', 'id');
    }
}