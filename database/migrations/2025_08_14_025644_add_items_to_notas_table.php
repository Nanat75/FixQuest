<?php

// database/migrations/2025_01_01_000001_add_items_to_notas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('notas', function (Blueprint $table) {
            // use json on MySQL 5.7+/MariaDB 10.2.7+; otherwise use text
            $table->json('items')->nullable()->after('harga');
        });
    }

    public function down(): void {
        Schema::table('notas', function (Blueprint $table) {
            $table->dropColumn('items');
        });
    }
};
