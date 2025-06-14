<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anak';

    protected $fillable = [
        'keluarga_id',
        'nama',
        'nik',
        'tempat_lahir',
        'tgl_lahir',
        'gender',
        'status_bekerja',
        'status_hidup',
        'status_anak',
        'status_tanggungan',
        'status_pernikahan',
    ];

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }
}
