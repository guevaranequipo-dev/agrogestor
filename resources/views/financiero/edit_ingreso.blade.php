<x-app-layout>
    <x-slot name="header">
        <h2>Editar Ingreso</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'Mis Fincas' => route('fincas.index'),
                'Ingresos' => route('financiero.index', $finca),
                'Editar Ingreso' => '',
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header text-white"
                             style="background: #1a3a2a;">
                            📈 Editar Ingreso
                        </div>
                        <div class="card-body">

                            <form action="{{ route('financiero.updateIngreso', [$finca, $ingreso]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Descripción *</label>
                                    <input type="text" name="descripcion"
                                           class="form-control @error('descripcion') is-invalid @enderror"
                                           value="{{ old('descripcion', $ingreso->descripcion) }}"
                                           required>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Monto *</label>
                                    <input type="number" name="monto" step="0.01" min="0"
                                           class="form-control @error('monto') is-invalid @enderror"
                                           value="{{ old('monto', $ingreso->monto) }}"
                                           required>
                                    @error('monto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Categoría</label>
                                    <select name="categoria" class="form-select">
                                        <option value="">-- Sin categoría --</option>
                                        <option value="venta_cosecha" {{ old('categoria', $ingreso->categoria) == 'venta_cosecha' ? 'selected' : '' }}>Venta de Cosecha</option>
                                        <option value="venta_ganado" {{ old('categoria', $ingreso->categoria) == 'venta_ganado' ? 'selected' : '' }}>Venta de Ganado</option>
                                        <option value="arriendo" {{ old('categoria', $ingreso->categoria) == 'arriendo' ? 'selected' : '' }}>Arriendo</option>
                                        <option value="subsidio" {{ old('categoria', $ingreso->categoria) == 'subsidio' ? 'selected' : '' }}>Subsidio</option>
                                        <option value="otro" {{ old('categoria', $ingreso->categoria) == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Fecha *</label>
                                    <input type="date" name="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha', \Carbon\Carbon::parse($ingreso->fecha)->format('Y-m-d')) }}"
                                           required>
                                    @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('financiero.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-warning fw-bold">Actualizar Ingreso</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>