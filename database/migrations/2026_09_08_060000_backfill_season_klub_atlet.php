<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('season_klub')->orderBy('id')->each(function (object $seasonKlub): void {
            $atletIds = DB::table('atlet')
                ->where('klub_id', $seasonKlub->klub_id)
                ->pluck('id');

            if ($atletIds->isEmpty()) {
                return;
            }

            $rows = $atletIds->map(fn($atletId) => [
                'season_klub_id' => $seasonKlub->id,
                'atlet_id' => $atletId,
                'created_at' => now(),
                'updated_at' => now(),
            ])->all();

            DB::table('season_klub_atlet')->insertOrIgnore($rows);
        });
    }

    public function down(): void
    {
    }
};