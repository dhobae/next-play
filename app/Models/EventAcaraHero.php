<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAcaraHero extends Model
{
    use HasFactory;

    protected $table = 'event_acara_hero';

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
    ];
}