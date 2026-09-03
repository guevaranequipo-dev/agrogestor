<x-app-layout>
    <x-slot name="header">
        <h2>Dashboard</h2>
    </x-slot>

    <div class="container py-4">

        {{-- Bienvenida --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-3 anim-fade-down"
                    style="background: linear-gradient(135deg, #1a3a2a, #2d6a4f); color: white;">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('images/Logo_AgroGestor.png') }}" alt="Logo" style="height: 60px;">
                        <div>
                            <h3 class="fw-bold mb-1">👋 Bienvenido, {{ Auth::user()->name }}</h3>
                            <p class="mb-0" style="color: #c9a84c;">Sistema de Gestión de Fincas — AgroGestor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Estadísticas reales --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-1">
                    <div style="font-size: 2.5rem;">🏡</div>
                    <p class="text-muted mb-1 mt-1">Mis Fincas</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">{{ $totalFincas }}</h3>
                    <small class="text-muted">registradas</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-2">
                    <div style="font-size: 2.5rem;">👷</div>
                    <p class="text-muted mb-1 mt-1">Trabajadores</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">{{ $totalTrabajadores }}</h3>
                    <small class="text-muted">en total</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-3">
                    <div style="font-size: 2.5rem;">📋</div>
                    <p class="text-muted mb-1 mt-1">Actividades</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">{{ $totalActividades }}</h3>
                    <small class="text-muted">programadas</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-4">
                    <div style="font-size: 2.5rem;">💵</div>
                    <p class="text-muted mb-1 mt-1">Total Pagado</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">${{ number_format($totalPagos, 0) }}</h3>
                    <small class="text-muted">en pagos</small>
                </div>
            </div>
        </div>

        {{-- Mis Fincas --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0" style="color: #1a3a2a;">🏡 Mis Fincas</h5>
            <a href="{{ route('fincas.create') }}" class="btn btn-sm text-white" style="background:#1a3a2a;">
                + Nueva Finca
            </a>
        </div>

        @if($fincas->isEmpty())
            <div class="alert alert-info anim-fade-up mb-4">
                No tienes fincas registradas.
                <a href="{{ route('fincas.create') }}">Crea la primera</a>.
            </div>
        @else
            <div class="row g-4 mb-4">
                @foreach($fincas as $finca)
                    <div class="col-md-4">
                        <a href="{{ route('fincas.show', $finca) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm h-100 card-hover anim-fade-up">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold" style="color: #1a3a2a;">🏡 {{ $finca->nombre }}</h5>
                                    <p class="text-muted mb-2">📍 {{ $finca->ubicacion ?? 'Sin ubicación' }}</p>
                                    <div class="d-flex justify-content-between text-muted small mb-1">
                                        <span>👷 {{ $finca->trabajadores_count }} trabajadores</span>
                                        <span>📋 {{ $finca->actividades_count }} actividades</span>
                                    </div>
                                    <div class="text-muted small">
                                        💵 ${{ number_format($finca->pagos_sum_total ?? 0, 0) }} pagados
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Acciones rápidas globales --}}
        <h5 class="fw-bold mb-3" style="color: #1a3a2a;">⚡ Acciones Rápidas</h5>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 card-hover anim-fade-up delay-1">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">➕</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Nueva Finca</h5>
                        <p class="text-muted">Registra una nueva finca en el sistema.</p>
                        <a href="{{ route('fincas.create') }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Crear</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 card-hover anim-fade-up delay-2">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">👤</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Mi Perfil</h5>
                        <p class="text-muted">Actualiza tus datos de cuenta.</p>
                        <a href="{{ route('profile.edit') }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Ver Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>