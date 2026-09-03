<x-app-layout>
    <x-slot name="header">
        <h2>Editar Gasto</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'Mis Fincas' => route('fincas.index'),
                'Gastos' => route('financiero.index', $finca),
                'Editar Gasto' => '',
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header text-white"
                             style="background: #742a2a;">
                            📉 Editar Gasto
                        </div>
                        <div class="card-body">

                            <form action="{{ route('financiero.updateGasto', [$finca, $gasto]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Descripción *</label>
                                    <input type="text" name="descripcion"
                                           class="form-control @error('descripcion') is-invalid @enderror"
                                           value="{{ old('descripcion', $gasto->descripcion) }}"
                                           required>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Monto *</label>
                                    <input type="number" name="monto" step="0.01" min="0"
                                           class="form-control @error('monto') is-invalid @enderror"
                                           value="{{ old('monto', $gasto->monto) }}"
                                           required>
                                    @error('monto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Categoría</label>
                                    <select name="categoria" class="form-select">
                                        <option value="">-- Sin categoría --</option>
                                        <option value="insumos" {{ old('categoria', $gasto->categoria) == 'insumos' ? 'selected' : '' }}>Insumos</option>
                                        <option value="mano_obra" {{ old('categoria', $gasto->categoria) == 'mano_obra' ? 'selected' : '' }}>Mano de Obra</option>
                                        <option value="maquinaria" {{ old('categoria', $gasto->categoria) == 'maquinaria' ? 'selected' : '' }}>Maquinaria</option>
                                        <option value="transporte" {{ old('categoria', $gasto->categoria) == 'transporte' ? 'selected' : '' }}>Transporte</option>
                                        <option value="servicios" {{ old('categoria', $gasto->categoria) == 'servicios' ? 'selected' : '' }}>Servicios</option>
                                        <option value="otro" {{ old('categoria', $gasto->categoria) == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Fecha *</label>
                                    <input type="date" name="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', \Carbon\Carbon::parse($gasto->fecha)->format('Y-m-d')) }}"
                                           required>
                                    @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('financiero.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-warning fw-bold">Actualizar Gasto</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>