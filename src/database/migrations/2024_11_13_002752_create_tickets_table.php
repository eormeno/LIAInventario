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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('subject');  // Cambio de 'title' a 'subject'
            $table->text('description');
            $table->string('status');   // Agregamos el campo 'status' para coincidir con el modelo y la fábrica.
            $table->unsignedBigInteger('created_by')->nullable(); // Columna para el creador
            $table->unsignedBigInteger('updated_by')->nullable(); // Columna para el modificador
            $table->timestamps();

            // Añadir llaves foráneas para 'created_by' y 'updated_by'
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Eliminar llaves foráneas antes de eliminar la tabla
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('tickets');
    }
};

