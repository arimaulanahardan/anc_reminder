<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'tanggal_kunjungan',
        'waktu',
        'lokasi',
        'pesan_pengingat',
        'frekuensi_pengingat',
        'pengingat_otomatis',
    ];

    public function pasien(): belongsTo
    {
        return $this->belongsTo(Pasien::class);
    }
}
