<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Actividad
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'fincas' => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Nueva Actividad' => '#'
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Programar Nueva Actividad</div>
                        <div class="card-body">

                            <form action="{{ route('actividades.store', $finca) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nombre de la Actividad *</label>
                                    <input type="text" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="descripcion" rows="3"
                                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fecha Programada *</label>
                                    <input type="date" name="fecha_programada"
                                           class="form-control @error('fecha_programada') is-invalid @enderror"
                                           value="{{ old('fecha_programada') }}" required>
                                    @error('fecha_programada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Estado *</label>
                                    <select name="estado"
                                            class="form-select @error('estado') is-invalid @enderror" required>
                                        <option value="pendiente" selected>Pendiente</option>
                                        <option value="en_progreso">En Progreso</option>
                                        <option value="completada">Completada</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Trabajadores Asignados</label>
                                    <select name="trabajadores[]" class="form-select" multiple size="5">
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{ $trabajador->id }}">
                                                {{ $trabajador->nombre }} ({{ $trabajador->finca->nombre }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Mantén Ctrl presionado para seleccionar varios</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('actividades.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Guardar Actividad</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>