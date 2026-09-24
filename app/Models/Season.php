<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $table = 'season';

    protected $fillable = [
        'klub_id',
        'nama_season',
        'tanggal_mulai',
        'tanggal_selesai',
        'mp',
        'w',
        'l',
        'pp',
        'lp',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function riwayatTurnamen()
    {
        return $this->hasMany(AtletRiwayat::class);
    }

    public function klub()
    {
        return $this->belongsTo(Klub::class);
    }

    public function standingsKlub()
    {
        return $this->hasMany(SeasonKlub::class);
    }
}