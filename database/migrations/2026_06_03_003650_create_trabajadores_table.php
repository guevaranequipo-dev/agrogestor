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
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('cedula')->nullable();
            $table->string('telefono')->nullable();
            $table->decimal('salario_dia', 10, 2);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
