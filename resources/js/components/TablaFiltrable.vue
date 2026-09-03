<template>
    <div>
        <!-- Buscador --> 
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text" style="background: #1a3a2a; color: white; border: none;">
                    🔍
                </span>
                <input type="text"
                       class="form-control"
                       :placeholder="placeholder"
                       v-model="busqueda"
                       style="border-left: none;">
                <button v-if="busqueda"
                        class="btn btn-outline-secondary"
                        @click="busqueda = ''">
                    ✕
                </button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th v-for="columna in columnas" :key="columna.campo">
                            {{ columna.label }}
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="filasFiltradas.length === 0">
                        <td :colspan="columnas.length + 1" class="text-center text-muted py-4">
                            No se encontraron resultados para "<strong>{{ busqueda }}</strong>"
                        </td>
                    </tr>
                    <tr v-for="(fila, index) in filasFiltradas" :key="fila.id">
                        <td>{{ index + 1 }}</td>
                        <td v-for="columna in columnas.slice(1)" :key="columna.campo">
                            <span v-if="columna.tipo === 'badge'"
                                  :class="'badge ' + columna.color(fila[columna.campo])">
                                {{ columna.formato ? columna.formato(fila[columna.campo]) : fila[columna.campo] }}
                            </span>
                            <span v-else>
                                {{ columna.formato ? columna.formato(fila[columna.campo]) : (fila[columna.campo] ?? '-') }}
                            </span>
                        </td>
                        <td>
                            <slot name="acciones" :fila="fila"></slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Contador -->
        <small class="text-muted">
            Mostrando {{ filasFiltradas.length }} de {{ filas.length }} registros
        </small>
    </div>
</template>

<script>
export default {
    name: 'TablaFiltrable',

    props: {
        filas: {
            type: Array,
            default: () => []
        },
        columnas: {
            type: Array,
            default: () => []
        },
        placeholder: {
            type: String,
            default: 'Buscar...'
        },
        camposBusqueda: {
            type: Array,
            default: () => []
        }
    },

    data() {
        return {
            busqueda: ''
        }
    },

    computed: {
        filasFiltradas() {
            if (!this.busqueda.trim()) return this.filas;

            const termino = this.busqueda.toLowerCase().trim();

            return this.filas.filter(fila => {
                return this.camposBusqueda.some(campo => {
                    const valor = campo.split('.').reduce((obj, key) => obj?.[key], fila);
                    return String(valor ?? '').toLowerCase().includes(termino);
                });
            });
        }
    }
}
</script>