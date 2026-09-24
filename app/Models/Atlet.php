<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atlet extends Model
{
    use HasFactory;

    public function klub()
    {
        return $this->belongsTo(Klub::class);
    }

    public function riwayatTurnamen()
    {
        return $this->hasMany(AtletRiwayat::class, 'atlet_id');
    }

    protected $table = 'atlet';

    protected $fillable = [
        'nama_atlet',
        'foto_atlet',
        'level',
        'jenis_kelamin',
        'klub_id',
        'tempat_lahir',
        'tanggal_lahir',
        'kebangsaan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'jenis_kelamin' => 'integer',
    ];

    public function seasonKlubs()
{
    return $this->belongsToMany(
        SeasonKlub::class,
        'season_klub_atlet',
        'atlet_id',
        'season_klub_id'
    );
}
}
