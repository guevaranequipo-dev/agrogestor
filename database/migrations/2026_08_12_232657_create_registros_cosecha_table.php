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
        Schema::create('registros_cosecha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semana_id')->constrained('semanas_cosecha')->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->date('fecha');
            $table->decimal('kilos_manana', 8, 2)->default(0);
            $table->decimal('kilos_tarde', 8, 2)->default(0);
            $table->decimal('total_kilos', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['semana_id', 'trabajador_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_cosecha');
    }
};
