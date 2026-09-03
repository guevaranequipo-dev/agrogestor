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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->foreignId('finca_id')->constrained('fincas')->onDelete('cascade');
            $table->date('fecha');
            $table->boolean('presente')->default(true);
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->unique(['trabajador_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
