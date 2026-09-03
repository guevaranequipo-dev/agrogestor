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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->foreignId('finca_id')->constrained('fincas')->onDelete('cascade');
            $table->date('semana_inicio');
            $table->date('semana_fin');
            $table->integer('dias_trabajados');
            $table->decimal('total_pago', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
