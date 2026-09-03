<x-app-layout>
    <x-slot name="header">
        <h2>Pagos</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" id="app">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Pagos'        => '#',
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
                    <h4>Listado de Pagos</h4>
                </div>
                <a href="{{ route('pagos.create', $finca) }}" class="btn btn-success">
                    + Nuevo Pago
                </a>
            </div>

            @if($pagos->isEmpty())
                <div class="alert alert-info anim-fade-up">
                    No hay pagos registrados. ¡Registra uno nuevo!
                </div>
            @else
                @php $urlBase = url('fincas/' . $finca->id . '/pagos'); @endphp

                <tabla-filtrable
                    :filas="{{ json_encode($pagos->map(function($p) {
                        return [
                            'id' => $p->id,
                            'trabajador_nombre' => $p->trabajador->nombre,
                            'tipo_pago' => $p->tipo_pago,
                            'fecha' => $p->fecha,
                            'total' => $p->total,
                        ];
                    })) }}"
                    placeholder="Buscar por trabajador o tipo de pago..."
                    :campos-busqueda="['trabajador_nombre', 'tipo_pago', 'fecha']"
                    :columnas="[
                        { campo: '#', label: '#' },
                        { campo: 'trabajador_nombre', label: 'Trabajador' },
                        { campo: 'tipo_pago', label: 'Tipo', tipo: 'badge',
                          color: (v) => v === 'jornal' ? 'bg-primary' : v === 'contrato' ? 'bg-warning text-dark' : 'bg-success',
                          formato: (v) => v === 'jornal' ? 'Jornal' : v === 'contrato' ? 'Contrato' : 'Recolección'
                        },
                        { campo: 'fecha', label: 'Fecha' },
                        { campo: 'total', label: 'Total', formato: (v) => '$' + Number(v).toLocaleString('es-CO') },
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
            if (confirm('¿Eliminar este pago?')) {
                e.target.submit();
            }
        }
    </script>
</x-app-layout>