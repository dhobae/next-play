<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonKlub extends Model
{
    protected $table = 'season_klub';

    protected $fillable = ['season_id', 'klub_id', 'mp', 'w', 'l', 'pp', 'lp'];

    protected $casts = [
        'mp' => 'integer',
        'w' => 'integer',
        'l' => 'integer',
        'pp' => 'integer',
        'lp' => 'integer',
    ];

    public function klub()
    {
        return $this->belongsTo(Klub::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function atlets()
    {
        return $this->belongsToMany(
            Atlet::class,
            'season_klub_atlet',
            'season_klub_id',
            'atlet_id'
        );
    }
}