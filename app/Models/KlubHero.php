<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlubHero extends Model
{
    protected $table = 'klub_hero';

    protected $fillable = ['judul', 'subjudul', 'gambar'];
}