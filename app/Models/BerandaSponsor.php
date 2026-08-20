<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerandaSponsor extends Model
{
    use HasFactory;

    protected $table = 'beranda_sponsor';
    protected $fillable = [
        'nama_sponsor',
        'gambar',
    ];
}
