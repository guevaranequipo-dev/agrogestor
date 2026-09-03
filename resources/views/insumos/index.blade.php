<x-app-layout>
    <x-slot name="header">
        <h2>Insumos</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" id="app">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Insumos'      => '#',
            ]"/>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show anim-fade-up" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4 anim-fade-up">
                <div>
                    <a href="{{ route('fincas.show', $finca) }}" class="btn btn-secondary btn-sm mb-2">
                        ← Volver a {{ $finca->nombre }}
                    </a>
                    <h4>Catálogo de Insumos</h4>
                </div>
                <a href="{{ route('insumos.create', $finca) }}" class="btn btn-success">
                    + Nuevo Insumo
                </a>
            </div>

            @if($insumos->isEmpty())
                <div class="alert alert-info anim-fade-up">
                    No tienes insumos registrados. ¡Agrega uno nuevo!
                </div>
            @else
                @php $urlBase = url('fincas/' . $finca->id . '/insumos'); @endphp

                <tabla-filtrable
                    :filas="{{ json_encode($insumos) }}"
                    placeholder="Buscar insumo por nombre o tipo..."
                    :campos-busqueda="['nombre', 'tipo', 'unidad_medida']"
                    :columnas="[
                        { campo: '#', label: '#' },
                        { campo: 'nombre', label: 'Nombre' },
                        { campo: 'tipo', label: 'Tipo', tipo: 'badge',
                          color: (v) => v === 'fertilizante' ? 'bg-success' : v === 'abono' ? 'bg-primary' : v === 'veneno' ? 'bg-danger' : 'bg-secondary',
                          formato: (v) => v.charAt(0).toUpperCase() + v.slice(1)
                        },
                        { campo: 'unidad_medida', label: 'Unidad' },
                        { campo: 'cantidad_disponible', label: 'Cantidad' },
                        { campo: 'precio_unitario', label: 'Precio', formato: (v) => v ? '$' + Number(v).toLocaleString('es-CO') : '-' },
                    ]"
                    url-base="{{ $urlBase }}">
                    <template #acciones="{ fila }">
                        <a :href="`{{ $urlBase }}/${fila.id}/edit`"
                           class="btn btn-warning btn-sm">Editar</a>
                        <form :action="`{{ $urlBase }}/${fila.id}`"
                              method="POST" class="d-inline"
                              @submit.prevent="confirmarEliminar($event)">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                        </form>
                    </template>
                </tabla-filtrable>
            @endif

        </div>
    </div>

    <script>
        function confirmarEliminar(e) {
            if (confirm('¿Eliminar este insumo?')) {
                e.target.submit();
            }
        }
    </script>
</x-app-layout>