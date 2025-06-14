<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip_pegawai',
        'nama',
        'foto',
        'tempat_lahir',
        'tgl_lahir',
        'gender',
        'no_hp',
        'alamat',
        'tgl_masuk',
        'jabatan_id',
        'divisi_id',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nip_pegawai', 'nip');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    public function keluarga()
    {
        return $this->hasOne(Keluarga::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
