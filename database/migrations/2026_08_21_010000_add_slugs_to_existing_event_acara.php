<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('event_acara', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('judul');
        });

        $usedSlugs = [];

        DB::table('event_acara')->orderBy('id')->each(function ($event) use (&$usedSlugs) {
            $baseSlug = Str::slug($event->judul) ?: 'event';
            $slug = $baseSlug;
            $counter = 2;

            while (isset($usedSlugs[$slug])) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $usedSlugs[$slug] = true;
            DB::table('event_acara')->where('id', $event->id)->update(['slug' => $slug]);
        });
    }

    public function down(): void
    {
        Schema::table('event_acara', function (Blueprint $table) {
            $table->dropUnique('event_acara_slug_unique');
            $table->dropColumn('slug');
        });
    }
};