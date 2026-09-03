<x-app-layout>
    <x-slot name="header">
        <h2>Cosecha</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Cosecha'      => '#',
            ]"/>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4 anim-fade-up">
                <div>
                    <a href="{{ route('fincas.show', $finca) }}" class="btn btn-secondary btn-sm mb-2">
                        ← Volver a {{ $finca->nombre }}
                    </a>
                    <h4>☕ Semanas de Cosecha</h4>
                </div>
                <a href="{{ route('cosecha.create', $finca) }}" class="btn btn-success">
                    + Nueva Semana
                </a>
            </div>

            @if($semanas->isEmpty())
                <div class="alert alert-info anim-fade-up">
                    No hay semanas de cosecha registradas. ¡Crea una nueva!
                </div>
            @else
                <div class="row g-4">
                    @foreach($semanas as $semana)
                        <div class="col-md-6 anim-fade-up delay-{{ $loop->index + 1 }}">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header d-flex justify-content-between align-items-center"
                                     style="background: {{ $semana->estado === 'abierta' ? '#1a3a2a' : '#4a5568' }}; color: white;">
                                    <span class="fw-bold">
                                        📅 {{ \Carbon\Carbon::parse($semana->fecha_inicio)->format('d/m/Y') }}
                                        — {{ \Carbon\Carbon::parse($semana->fecha_fin)->format('d/m/Y') }}
                                    </span>
                                    @if($semana->estado === 'abierta')
                                        <span class="badge bg-success">Abierta</span>
                                    @else
                                        <span class="badge bg-secondary">Cerrada</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 mb-3">
                                        <div class="col-6 text-center">
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Precio por Kilo</p>
                                            <h5 class="fw-bold" style="color: #c9a84c;">
                                                ${{ number_format($semana->precio_kilo, 0) }}
                                            </h5>
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Total Kilos</p>
                                            <h5 class="fw-bold" style="color: #1a3a2a;">
                                                {{ number_format($semana->totalKilos(), 2) }} kg
                                            </h5>
                                        </div>
                                        <div class="col-12 text-center">
                                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Total a Pagar</p>
                                            <h4 class="fw-bold" style="color: #1a3a2a;">
                                                ${{ number_format($semana->totalPagar(), 0) }}
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('cosecha.show', [$finca, $semana]) }}"
                                           class="btn btn-sm text-white fw-bold flex-grow-1"
                                           style="background: #1a3a2a;">
                                            Ver Detalle
                                        </a>

                                        @if($semana->estado === 'abierta')
                                            <form action="{{ route('cosecha.cerrarSemana', [$finca, $semana]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Cerrar semana y generar pagos automáticamente?')">
                                                @csrf
                                                <button class="btn btn-sm btn-warning fw-bold">
                                                    🔒 Cerrar y Pagar
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('cosecha.destroy', [$finca, $semana]) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Eliminar esta semana?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>