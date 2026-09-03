<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Fincas
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'Mis Fincas' => route('fincas.index'),
            ]"/>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Botón nueva finca --}}
            <div class="d-flex justify-content-between align-items-center mb-4 anim-fade-up">
                <h4>Listado de Fincas</h4>
                <a href="{{ route('fincas.create') }}" class="btn btn-success">
                    + Nueva Finca
                </a>
            </div>

            {{-- Tabla de fincas --}}
            @if($fincas->isEmpty())
                <div class="alert alert-info anim-fade-up">
                    No tienes fincas registradas. ¡Crea una nueva!
                </div>
            @else
                <div class="table-responsive anim-fade-up delay-2">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Hectáreas</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fincas as $finca)
                                <tr class="anim-fade-up delay-{{ $loop->index + 1 }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $finca->nombre }}</td>
                                    <td>{{ $finca->ubicacion ?? '-' }}</td>
                                    <td>{{ $finca->hectareas ?? '-' }}</td>
                                    <td>{{ $finca->descripcion ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('fincas.show', $finca) }}"
                                        class="btn btn-success btn-sm">Ver</a>

                                        <a href="{{ route('fincas.edit', $finca) }}"
                                        class="btn btn-warning btn-sm">Editar</a>

                                        <form action="{{ route('fincas.destroy', $finca) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('¿Eliminar esta finca?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>