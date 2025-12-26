<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('notas', function (Blueprint $table) {
        $table->string('no')->nullable()->after('id'); // or use integer if you want numbers only
    });
}

public function down()
{
    Schema::table('notas', function (Blueprint $table) {
        $table->dropColumn('no');
    });
}

};
