<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';

    protected $fillable = [
        'pegawai_id',
        'status_pernikahan',
        'no_kk',
        'nama_pasangan',
        'gender',
        'nik_pasangan',
        'agama',
        'no_telp_pasangan',
        'pendidikan_terakhir',
        'status_bekerja_pasangan',
        'status_pasangan',
        'nama_ayah',
        'status_bekerja_ayah',
        'status_ayah',
        'no_telp_ayah',
        'nama_ibu',
        'status_bekerja_ibu',
        'no_telp_ibu',
        'status_ibu',
        'alamat_ortu',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Relasi ke anak (one keluarga punya banyak anak)
    public function anak()
    {
        return $this->hasMany(Anak::class);
    }
}
