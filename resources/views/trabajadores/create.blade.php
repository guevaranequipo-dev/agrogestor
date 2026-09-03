<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Trabajador
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'Mis Fincas'    => route('fincas.index'),
                $finca->nombre  => route('fincas.show', $finca),
                'Trabajadores'  => route('trabajadores.index', $finca),
                'Nuevo Trabajador' => '#',
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Registrar Nuevo Trabajador</div>
                        <div class="card-body">

                            <form action="{{ route('trabajadores.store', $finca) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <input type="text" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Cédula</label>
                                    <input type="text" name="cedula"
                                           class="form-control @error('cedula') is-invalid @enderror"
                                           value="{{ old('cedula') }}">
                                    @error('cedula')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="telefono"
                                           class="form-control @error('telefono') is-invalid @enderror"
                                           value="{{ old('telefono') }}">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Salario por Día *</label>
                                    <input type="number" name="salario_dia" step="0.01"
                                           class="form-control @error('salario_dia') is-invalid @enderror"
                                           value="{{ old('salario_dia') }}" required>
                                    @error('salario_dia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select">
                                        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('trabajadores.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Guardar Trabajador</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>