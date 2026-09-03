<x-app-layout>
    <x-slot name="header">
        <h2>Trabajadores</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" id="app">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Trabajadores' => '#',
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
                    <h4>Listado de Trabajadores</h4>
                </div>
                <a href="{{ route('trabajadores.create', $finca) }}" class="btn btn-success">
                    + Nuevo Trabajador
                </a>
            </div>

            @if($trabajadores->isEmpty())
                <div class="alert alert-info anim-fade-up">
                    No tienes trabajadores registrados. ¡Agrega uno nuevo!
                </div>
            @else
                @php $urlBase = url('fincas/' . $finca->id . '/trabajadores'); @endphp

                <tabla-filtrable
                    :filas="{{ json_encode($trabajadores) }}"
                    placeholder="Buscar trabajador por nombre, cédula o teléfono..."
                    :campos-busqueda="['nombre', 'cedula', 'telefono']"
                    :columnas="[
                        { campo: '#', label: '#' },
                        { campo: 'nombre', label: 'Nombre' },
                        { campo: 'cedula', label: 'Cédula' },
                        { campo: 'telefono', label: 'Teléfono' },
                        { campo: 'salario_dia', label: 'Salario/Día', formato: (v) => '$' + Number(v).toLocaleString('es-CO') },
                        { campo: 'estado', label: 'Estado', tipo: 'badge', color: (v) => v ? 'bg-success' : 'bg-danger', formato: (v) => v ? 'Activo' : 'Inactivo' },
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
            if (confirm('¿Eliminar este trabajador?')) {
                e.target.submit();
            }
        }
    </script>
</x-app-layout>