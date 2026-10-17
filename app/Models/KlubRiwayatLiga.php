<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlubRiwayatLiga extends Model
{
    protected $table = 'klub_riwayat_liga';

    protected $fillable = [
        'klub_id',
        'nama_liga',
        'hasil_liga',
        'tanggal_liga',
        'poin_liga',
    ];

    protected $casts = [
        'tanggal_liga' => 'date',
        'hasil_liga' => 'string',
        'poin_liga' => 'integer',
    ];

    public function klub()
    {
        return $this->belongsTo(Klub::class);
    }
}