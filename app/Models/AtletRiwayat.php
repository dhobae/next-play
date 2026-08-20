<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtletRiwayat extends Model
{
    use HasFactory;

    public function atlet()
    {
        return $this->belongsTo(Atlet::class);
    }

    protected $table = 'atlet_riwayat_turnamen';

    protected $fillable = [
        'atlet_id',
        'nama_turnamen',
        'tanggal_turnamen',
        'hasil_turnamen',
        'poin_turnamen',
    ];

    protected $casts = [
        'tanggal_turnamen' => 'date',
        'poin_turnamen' => 'integer',
    ];
}
