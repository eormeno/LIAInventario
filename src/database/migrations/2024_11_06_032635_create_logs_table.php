<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('logs', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('user_id')->constrained();
    //         $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
    //         $table->string('imagen')->nullable();
    //         $table->string('estado');
    //         $table->string('comentario');
    //         $table->timestamps();
    //     });
    // }

    // En la migración de la tabla `logs`
public function up()
{
    Schema::create('logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('ticket_id');
        $table->unsignedBigInteger('user_id');
    //    $table->string('action');
        $table->timestamps();
        $table->string('estado');
        $table->string('comentario');
        $table->string('imagen')->nullable();
        // Relaciones con los modelos
        $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
