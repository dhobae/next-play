<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtletHero extends Model
{
    use HasFactory;

    protected $table = 'atlet_hero';

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
    ];
}