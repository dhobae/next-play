<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAcara extends Model
{
    use HasFactory;

    protected $table = 'event_acara';
    protected $fillable = [
        'judul',
        'gambar',
        'tanggal',
        'deskripsi',
    ];
}
