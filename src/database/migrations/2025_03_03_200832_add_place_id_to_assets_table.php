<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedBigInteger('place_id')->nullable()->after('id'); // Clave foránea
            $table->foreign('place_id')->references('id')->on('places')->onDelete('set null'); // Relación con onDelete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Elimina la clave foránea y la columna
            $table->dropForeign(['place_id']); // Elimina la relación foránea
            $table->dropColumn('place_id'); // Elimina la columna
        });
    }
};
