<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventAcara extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (EventAcara $event) {
            $event->slug = static::makeUniqueSlug($event->judul);
        });
    }

    private static function makeUniqueSlug(string $judul): string
    {
        $slug = Str::slug($judul) ?: 'event';
        $originalSlug = $slug;
        $counter = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $table = 'event_acara';
    protected $fillable = [
        'judul',
        'gambar',
        'tanggal',
        'deskripsi',
    ];
}
