<template>
    <div>
        <!-- Trabajador -->
        <div class="mb-3">
            <label class="form-label fw-bold">Trabajador *</label>
            <select name="trabajador_id"
                    class="form-select"
                    v-model="form.trabajador_id"
                    required>
                <option value="">-- Selecciona un trabajador --</option>
                <option v-for="trabajador in trabajadores"
                        :key="trabajador.id"
                        :value="trabajador.id">
                    {{ trabajador.nombre }}
                </option>
            </select>
        </div>

        <!-- Tipo de pago -->
        <div class="mb-3">
            <label class="form-label fw-bold">Tipo de Pago *</label>
            <select name="tipo_pago"
                    class="form-select"
                    v-model="form.tipo_pago"
                    required>
                <option value="">-- Selecciona el tipo --</option>
                <option value="jornal">Jornal (por día)</option>
                <option value="contrato">Contrato</option>
                <option value="recoleccion">Recolección</option>
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
            <label class="form-label fw-bold">Fecha *</label>
            <input type="date"
                   name="fecha"
                   class="form-control"
                   v-model="form.fecha"
                   required>
        </div>

        <!-- Campos Jornal -->
        <div v-if="form.tipo_pago === 'jornal'">
            <div class="mb-3">
                <label class="form-label fw-bold">Días Trabajados *</label>
                <input type="number"
                       name="dias_trabajados"
                       class="form-control"
                       v-model="form.dias_trabajados"
                       min="1"
                       @input="calcularTotal">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Valor por Día *</label>
                <input type="number"
                       name="valor_dia"
                       class="form-control"
                       v-model="form.valor_dia"
                       step="0.01"
                       min="0"
                       @input="calcularTotal">
            </div>
        </div>

        <!-- Campos Contrato -->
        <div v-if="form.tipo_pago === 'contrato'">
            <div class="mb-3">
                <label class="form-label fw-bold">Descripción del Contrato *</label>
                <textarea name="descripcion_contrato"
                          class="form-control"
                          v-model="form.descripcion_contrato"
                          rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Valor del Contrato *</label>
                <input type="number"
                       name="valor_contrato"
                       class="form-control"
                       v-model="form.valor_contrato"
                       step="0.01"
                       min="0"
                       @input="calcularTotal">
            </div>
        </div>

        <!-- Campos Recolección -->
        <div v-if="form.tipo_pago === 'recoleccion'">
            <div class="mb-3">
                <label class="form-label fw-bold">Cantidad Recolectada (kg) *</label>
                <input type="number"
                       name="cantidad_recolectada"
                       class="form-control"
                       v-model="form.cantidad_recolectada"
                       step="0.01"
                       min="0"
                       @input="calcularTotal">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Precio por Kg *</label>
                <input type="number"
                       name="precio_por_kg"
                       class="form-control"
                       v-model="form.precio_por_kg"
                       step="0.01"
                       min="0"
                       @input="calcularTotal">
            </div>
        </div>

        <!-- Total calculado -->
        <div v-if="totalCalculado > 0" class="alert mb-4"
             style="background: #1a3a2a; color: white; border-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">💵 Total a Pagar:</span>
                <span class="fw-bold" style="font-size: 1.4rem; color: #c9a84c;">
                    ${{ totalCalculado.toLocaleString('es-CO') }}
                </span>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'FormularioPago',

    props: {
        trabajadores: {
            type: Array,
            default: () => []
        },
        inicial: {
            type: Object,
            default: () => ({})
        }
    },

    data() {
        return {
            form: {
                trabajador_id: this.inicial.trabajador_id || '',
                tipo_pago: this.inicial.tipo_pago || '',
                fecha: this.inicial.fecha || '',
                dias_trabajados: this.inicial.dias_trabajados || '',
                valor_dia: this.inicial.valor_dia || '',
                descripcion_contrato: this.inicial.descripcion_contrato || '',
                valor_contrato: this.inicial.valor_contrato || '',
                cantidad_recolectada: this.inicial.cantidad_recolectada || '',
                precio_por_kg: this.inicial.precio_por_kg || '',
            },
            totalCalculado: 0,
        }
    },

    watch: {
        'form.tipo_pago'() {
            this.totalCalculado = 0;
        }
    },

    methods: {
        calcularTotal() {
            const tipo = this.form.tipo_pago;

            if (tipo === 'jornal') {
                const dias = parseFloat(this.form.dias_trabajados) || 0;
                const valor = parseFloat(this.form.valor_dia) || 0;
                this.totalCalculado = dias * valor;

            } else if (tipo === 'contrato') {
                this.totalCalculado = parseFloat(this.form.valor_contrato) || 0;

            } else if (tipo === 'recoleccion') {
                const cantidad = parseFloat(this.form.cantidad_recolectada) || 0;
                const precio = parseFloat(this.form.precio_por_kg) || 0;
                this.totalCalculado = cantidad * precio;
            }
        }
    }
}
</script>