<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Finca
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'fincas' => route('fincas.index'),
                'Nueva Finca' => route('fincas.create')
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Registrar Nueva Finca</div>
                        <div class="card-body">

                            <form action="{{ route('fincas.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nombre de la Finca *</label>
                                    <input type="text" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" name="ubicacion"
                                           class="form-control @error('ubicacion') is-invalid @enderror"
                                           value="{{ old('ubicacion') }}">
                                    @error('ubicacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Hectáreas</label>
                                    <input type="number" name="hectareas" step="0.01"
                                           class="form-control @error('hectareas') is-invalid @enderror"
                                           value="{{ old('hectareas') }}">
                                    @error('hectareas')
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

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('fincas.index') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Guardar Finca</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>