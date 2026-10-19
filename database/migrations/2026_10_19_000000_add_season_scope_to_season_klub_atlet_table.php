<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('season_klub_atlet')
            ->join('season_klub', 'season_klub.id', '=', 'season_klub_atlet.season_klub_id')
            ->select('season_klub.season_id', 'season_klub_atlet.atlet_id')
            ->groupBy('season_klub.season_id', 'season_klub_atlet.atlet_id')
            ->havingRaw('COUNT(*) > 1')
            ->limit(10)
            ->get();

        if ($duplicates->isNotEmpty()) {
            $conflicts = $duplicates
                ->map(fn (object $row) => "season {$row->season_id}, atlet {$row->atlet_id}")
                ->implode('; ');

            throw new \RuntimeException(
                "Cannot enforce one club per athlete per season. Resolve these existing duplicate memberships first: {$conflicts}"
            );
        }

        Schema::table('season_klub_atlet', function (Blueprint $table): void {
            $table->foreignId('season_id')
                ->nullable()
                ->after('season_klub_id')
                ->constrained('season')
                ->cascadeOnDelete();
        });

        DB::table('season_klub_atlet')
            ->join('season_klub', 'season_klub.id', '=', 'season_klub_atlet.season_klub_id')
            ->select('season_klub_atlet.id as pivot_id', 'season_klub.season_id')
            ->orderBy('season_klub_atlet.id')
            ->chunk(500, function ($rows): void {
                foreach ($rows as $row) {
                    DB::table('season_klub_atlet')
                        ->where('id', $row->pivot_id)
                        ->update(['season_id' => $row->season_id]);
                }
            });

        if (DB::table('season_klub_atlet')->whereNull('season_id')->exists()) {
            throw new \RuntimeException('Unable to backfill season_id for every athlete season membership.');
        }

        Schema::table('season_klub_atlet', function (Blueprint $table): void {
            $table->unsignedBigInteger('season_id')->nullable(false)->change();
        });

        Schema::table('season_klub_atlet', function (Blueprint $table): void {
            $table->unique(['season_id', 'atlet_id']);
        });
    }

    public function down(): void
    {
        Schema::table('season_klub_atlet', function (Blueprint $table): void {
            $table->dropUnique(['season_id', 'atlet_id']);
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');
        });
    }
};
