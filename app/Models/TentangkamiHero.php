<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangkamiHero extends Model
{
    use HasFactory;

    protected $table = 'tentangkami_hero';
    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
    ];
}
