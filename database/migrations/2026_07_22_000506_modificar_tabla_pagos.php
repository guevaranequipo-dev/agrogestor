<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar columnas anteriores
            $table->dropColumn([
                'semana_inicio',
                'semana_fin',
                'dias_trabajados',
                'total_pago',
            ]);

            // Agregar nuevas columnas
            $table->enum('tipo_pago', ['jornal', 'contrato', 'recoleccion'])->after('finca_id');
            $table->date('fecha')->after('tipo_pago');

            // Para jornal
            $table->integer('dias_trabajados')->nullable()->after('fecha');
            $table->decimal('valor_dia', 10, 2)->nullable()->after('dias_trabajados');

            // Para contrato
            $table->text('descripcion_contrato')->nullable()->after('valor_dia');
            $table->decimal('valor_contrato', 10, 2)->nullable()->after('descripcion_contrato');

            // Para recoleccion
            $table->decimal('cantidad_recolectada', 10, 2)->nullable()->after('valor_contrato');
            $table->decimal('precio_por_kg', 10, 2)->nullable()->after('cantidad_recolectada');

            // Total
            $table->decimal('total', 10, 2)->after('precio_por_kg');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_pago',
                'fecha',
                'dias_trabajados',
                'valor_dia',
                'descripcion_contrato',
                'valor_contrato',
                'cantidad_recolectada',
                'precio_por_kg',
                'total',
            ]);

            $table->date('semana_inicio');
            $table->date('semana_fin');
            $table->integer('dias_trabajados');
            $table->decimal('total_pago', 10, 2);
        });
    }
};
