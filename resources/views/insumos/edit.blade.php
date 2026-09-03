<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Insumo
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'Mis Fincas'    => route('fincas.index'),
                $finca->nombre  => route('fincas.show', $finca),
                'Insumos'       => route('insumos.index', $finca),
                'Editar Insumo' => '#',
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Editar Insumo</div>
                        <div class="card-body">

                            <form action="{{ route('insumos.update', [$finca, $insumo]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nombre del Insumo *</label>
                                    <input type="text" name="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $insumo->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tipo *</label>
                                    <select name="tipo"
                                            class="form-select @error('tipo') is-invalid @enderror" required>
                                        <option value="fertilizante" {{ old('tipo', $insumo->tipo) == 'fertilizante' ? 'selected' : '' }}>Fertilizante</option>
                                        <option value="abono" {{ old('tipo', $insumo->tipo) == 'abono' ? 'selected' : '' }}>Abono</option>
                                        <option value="veneno" {{ old('tipo', $insumo->tipo) == 'veneno' ? 'selected' : '' }}>Veneno</option>
                                        <option value="otro" {{ old('tipo', $insumo->tipo) == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Unidad de Medida *</label>
                                    <input type="text" name="unidad_medida"
                                           class="form-control @error('unidad_medida') is-invalid @enderror"
                                           value="{{ old('unidad_medida', $insumo->unidad_medida) }}" required>
                                    @error('unidad_medida')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Cantidad Disponible *</label>
                                    <input type="number" name="cantidad_disponible" step="0.01"
                                           class="form-control @error('cantidad_disponible') is-invalid @enderror"
                                           value="{{ old('cantidad_disponible', $insumo->cantidad_disponible) }}" required>
                                    @error('cantidad_disponible')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Precio Unitario</label>
                                    <input type="number" name="precio_unitario" step="0.01"
                                           class="form-control @error('precio_unitario') is-invalid @enderror"
                                           value="{{ old('precio_unitario', $insumo->precio_unitario) }}">
                                    @error('precio_unitario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <textarea name="descripcion" rows="3"
                                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $insumo->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('insumos.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-warning">Actualizar Insumo</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>