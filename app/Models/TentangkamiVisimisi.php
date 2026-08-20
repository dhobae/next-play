<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangkamiVisimisi extends Model
{
    use HasFactory;

    protected $table = 'tentangkami_visimisi';
    protected $fillable = [
        'visi',
        'misi',
        'gambar',
    ];
}
