<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Actividad
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'fincas' => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Editar Actividad' => '#'
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Editar Actividad</div>
                        <div class="card-body">

                            <form action="{{ route('actividades.update', [$finca, $actividad]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nombre de la Actividad *</label>
                                    <input type="text" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $actividad->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="descripcion" rows="3"
                                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $actividad->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fecha Programada *</label>
                                    <input type="date" name="fecha_programada"
                                           class="form-control @error('fecha_programada') is-invalid @enderror"
                                           value="{{ old('fecha_programada', \Carbon\Carbon::parse($actividad->fecha_programada)->format('Y-m-d')) }}" required>
                                    @error('fecha_programada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Estado *</label>
                                    <select name="estado"
                                            class="form-select @error('estado') is-invalid @enderror" required>
                                        <option value="pendiente" {{ old('estado', $actividad->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en_progreso" {{ old('estado', $actividad->estado) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="completada" {{ old('estado', $actividad->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Trabajadores Asignados</label>
                                    <select name="trabajadores[]" class="form-select" multiple size="5">
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{ $trabajador->id }}"
                                                {{ in_array($trabajador->id, $trabajadoresAsignados) ? 'selected' : '' }}>
                                                {{ $trabajador->nombre }} ({{ $trabajador->finca->nombre }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Mantén Ctrl presionado para seleccionar varios</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('actividades.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-warning">Actualizar Actividad</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>