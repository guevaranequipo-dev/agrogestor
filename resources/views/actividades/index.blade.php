<x-app-layout>
    <x-slot name="header">
        <h2>Actividades</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" id="app">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Actividades'  => '#',
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
                    <h4>Listado de Actividades</h4>
                </div>
                <a href="{{ route('actividades.create', $finca) }}" class="btn btn-success">
                    + Nueva Actividad
                </a>
            </div>

            @if($actividades->isEmpty())
                <div class="alert alert-info anim-fade-up">
                    No tienes actividades programadas. ¡Crea una nueva!
                </div>
            @else
                @php $urlBase = url('fincas/' . $finca->id . '/actividades'); @endphp

                <tabla-filtrable
                    :filas="{{ json_encode($actividades) }}"
                    placeholder="Buscar actividad por nombre o estado..."
                    :campos-busqueda="['nombre', 'estado', 'fecha_programada']"
                    :columnas="[
                        { campo: '#', label: '#' },
                        { campo: 'nombre', label: 'Nombre' },
                        { campo: 'fecha_programada', label: 'Fecha' },
                        { campo: 'estado', label: 'Estado', tipo: 'badge',
                          color: (v) => v === 'pendiente' ? 'bg-secondary' : v === 'en_progreso' ? 'bg-warning text-dark' : 'bg-success',
                          formato: (v) => v === 'pendiente' ? 'Pendiente' : v === 'en_progreso' ? 'En Progreso' : 'Completada'
                        },
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
            if (confirm('¿Eliminar esta actividad?')) {
                e.target.submit();
            }
        }
    </script>
</x-app-layout>