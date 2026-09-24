<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('season', function (Blueprint $table) {
            $table->foreignId('klub_id')->nullable()->after('id')->constrained('klub')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('season', function (Blueprint $table) {
            $table->dropForeign(['klub_id']);
            $table->dropColumn('klub_id');
        });
    }
};