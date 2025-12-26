<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Add the column (nullable first, then unique)
        Schema::table('notas', function (Blueprint $table) {
            // string length 20 is more than enough for formats like N0001, N-2025-0001, etc.
            $table->string('no', 20)->nullable()->unique()->after('id');
        });

        // 2) Backfill existing rows with sequential numbers based on created_at (then id for stability)
        $counter = 1;
        $rows = DB::table('notas')
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->get(['id', 'no']);

        foreach ($rows as $row) {
            // Skip if already has a value (in case you re-run)
            if (!empty($row->no)) {
                continue;
            }

  
            // Format: 01, 02, 03, ...
                $no = str_pad($counter, 2, '0', STR_PAD_LEFT);


            DB::table('notas')->where('id', $row->id)->update(['no' => $no]);
            $counter++;
        }

        // (Optional) If you want to force NOT NULL at DB level later,
        // you need doctrine/dbal. If you don't have it, you can keep it nullable
        // and rely on validation in your controller.
        //
        // Schema::table('notas', function (Blueprint $table) {
        //     $table->string('no', 20)->nullable(false)->change();
        // });
    }

    public function down(): void
    {
        // drop unique index first, then column
        Schema::table('notas', function (Blueprint $table) {
            // Default index name is table_column_unique
            $table->dropUnique('notas_no_unique');
            $table->dropColumn('no');
        });
    }
};
