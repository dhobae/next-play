<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerandaCarousel extends Model
{
    use HasFactory;

    protected $table = 'beranda_carousel';
    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
    ];
}
