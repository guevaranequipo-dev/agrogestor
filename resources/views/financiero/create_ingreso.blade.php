<x-app-layout>
    <x-slot name="header">
        <h2>Nuevo Ingreso</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <x-breadcrumb :links="[
                'Mis Fincas' => route('fincas.index'),
                'Ingresos' => route('financiero.index', $finca),
                'Nuevo Ingreso' => '',
            ]"/>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header text-white"
                             style="background: #1a3a2a;">
                            📈 Registrar Nuevo Ingreso
                        </div>
                        <div class="card-body">

                            <form action="{{ route('financiero.storeIngreso', $finca) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Descripción *</label>
                                    <input type="text" name="descripcion"
                                           class="form-control @error('descripcion') is-invalid @enderror"
                                           value="{{ old('descripcion') }}"
                                           placeholder="Ej: Venta de cosecha de café"
                                           required>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Monto *</label>
                                    <input type="number" name="monto" step="0.01" min="0"
                                           class="form-control @error('monto') is-invalid @enderror"
                                           value="{{ old('monto') }}"
                                           placeholder="0"
                                           required>
                                    @error('monto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Categoría</label>
                                    <select name="categoria" class="form-select">
                                        <option value="">-- Sin categoría --</option>
                                        <option value="venta_cosecha" {{ old('categoria') == 'venta_cosecha' ? 'selected' : '' }}>Venta de Cosecha</option>
                                        <option value="venta_ganado" {{ old('categoria') == 'venta_ganado' ? 'selected' : '' }}>Venta de Ganado</option>
                                        <option value="arriendo" {{ old('categoria') == 'arriendo' ? 'selected' : '' }}>Arriendo</option>
                                        <option value="subsidio" {{ old('categoria') == 'subsidio' ? 'selected' : '' }}>Subsidio</option>
                                        <option value="otro" {{ old('categoria') == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Fecha *</label>
                                    <input type="date" name="fecha"
                                           class="form-control @error('fecha') is-invalid @enderror"
                                           value="{{ old('fecha') }}"
                                           required>
                                    @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('financiero.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn text-white fw-bold"
                                            style="background: #1a3a2a;">Guardar Ingreso</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>