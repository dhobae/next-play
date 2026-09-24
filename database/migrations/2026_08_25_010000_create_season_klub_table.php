<?php

use App\Models\Season;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('season_klub', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained('season')->cascadeOnDelete();
            $table->foreignId('klub_id')->constrained('klub')->cascadeOnDelete();
            $table->unsignedInteger('mp')->default(0);
            $table->unsignedInteger('w')->default(0);
            $table->unsignedInteger('l')->default(0);
            $table->unsignedInteger('pp')->default(0);
            $table->unsignedInteger('lp')->default(0);
            $table->timestamps();
            $table->unique(['season_id', 'klub_id']);
        });

        Season::query()->whereNotNull('klub_id')->each(function (Season $season) {
            DB::table('season_klub')->insert([
                'season_id' => $season->id,
                'klub_id' => $season->klub_id,
                'mp' => $season->mp,
                'w' => $season->w,
                'l' => $season->l,
                'pp' => $season->pp,
                'lp' => $season->lp,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('season_klub');
    }
};