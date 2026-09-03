<x-app-layout>
    <x-slot name="header">
        <h2>Nueva Semana de Cosecha</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Cosecha'      => route('cosecha.index', $finca),
                'Nueva Semana' => '#',
            ]"/>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm anim-fade-up">
                        <div class="card-header text-white fw-bold"
                             style="background: #1a3a2a;">
                            ☕ Crear Nueva Semana de Cosecha
                        </div>
                        <div class="card-body">

                            <form action="{{ route('cosecha.store', $finca) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Fecha Inicio (Lunes) *</label>
                                    <input type="date" name="fecha_inicio"
                                           class="form-control @error('fecha_inicio') is-invalid @enderror"
                                           value="{{ old('fecha_inicio', $lunes) }}" required>
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Fecha Fin (Domingo) *</label>
                                    <input type="date" name="fecha_fin"
                                           class="form-control @error('fecha_fin') is-invalid @enderror"
                                           value="{{ old('fecha_fin', $domingo) }}" required>
                                    @error('fecha_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Precio por Kilo *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                              style="background: #1a3a2a; color: white; border: none;">$</span>
                                        <input type="number" name="precio_kilo" step="0.01" min="0"
                                               class="form-control @error('precio_kilo') is-invalid @enderror"
                                               value="{{ old('precio_kilo') }}"
                                               placeholder="1000" required>
                                    </div>
                                    @error('precio_kilo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('cosecha.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn text-white fw-bold"
                                            style="background: #1a3a2a;">Crear Semana</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>