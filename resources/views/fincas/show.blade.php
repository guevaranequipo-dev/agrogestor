<x-app-layout>
    <x-slot name="header">
        <h2>{{ $finca->nombre }}</h2>
    </x-slot>

    <div class="container py-4">

        {{-- Info de la finca --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-3 d-flex justify-content-between align-items-center anim-fade-down"
                    style="background: linear-gradient(135deg, #1a3a2a, #2d6a4f); color: white;">
                    <div>
                        <h3 class="fw-bold mb-1">🏡 {{ $finca->nombre }}</h3>
                        <p class="mb-0" style="color: #c9a84c;">
                            📍 {{ $finca->ubicacion ?? 'Sin ubicación' }}
                            @if($finca->hectareas)
                                &nbsp;|&nbsp; 🌿 {{ $finca->hectareas }} hectáreas
                            @endif
                        </p>
                        @if($finca->descripcion)
                            <p class="mb-0 mt-1" style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                                {{ $finca->descripcion }}
                            </p>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('fincas.edit', $finca) }}" class="btn btn-sm"
                           style="background: #c9a84c; color: #1a3a2a; font-weight: 600;">✏️ Editar</a>
                        <a href="{{ route('fincas.index') }}" class="btn btn-sm btn-light">← Mis Fincas</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Estadísticas de la finca --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-1">
                    <div style="font-size: 2rem;">👷</div>
                    <p class="text-muted mb-1 mt-1">Trabajadores</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">{{ $totalTrabajadores }}</h3>
                    <small class="text-success">{{ $trabajadoresActivos }} activos</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-2">
                    <div style="font-size: 2rem;">📋</div>
                    <p class="text-muted mb-1 mt-1">Actividades</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">{{ $actividadesPendientes + $actividadesEnProgreso }}</h3>
                    <small class="text-warning">{{ $actividadesPendientes }} pendientes</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-3">
                    <div style="font-size: 2rem;">💵</div>
                    <p class="text-muted mb-1 mt-1">Total Pagado</p>
                    <h3 class="fw-bold" style="color: #1a3a2a;">${{ number_format($totalPagado, 0) }}</h3>
                    <small class="text-muted">en pagos</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-4">
                    <div style="font-size: 2rem;">💰</div>
                    <p class="text-muted mb-1 mt-1">Balance</p>
                    <h3 class="fw-bold" style="color: {{ $balance >= 0 ? '#1a3a2a' : '#dc3545' }}">
                        ${{ number_format($balance, 0) }}
                    </h3>
                    <small class="text-muted">ingresos vs gastos</small>
                </div>
            </div>
        </div>

        {{-- Próximas actividades --}}
        @if($proximasActividades->count() > 0)
            <div class="card border-0 shadow-sm mb-4 anim-fade-up">
                <div class="card-header fw-bold text-white" style="background: #1a3a2a;">
                    📅 Próximas Actividades
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Actividad</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proximasActividades as $actividad)
                                <tr>
                                    <td>{{ $actividad->nombre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($actividad->fecha_programada)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($actividad->estado == 'pendiente')
                                            <span class="badge bg-secondary">Pendiente</span>
                                        @else
                                            <span class="badge bg-warning">En Progreso</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Módulos --}}
        <h5 class="fw-bold mb-3" style="color: #1a3a2a;">⚡ Módulos de la Finca</h5>
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-1">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">👷</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Trabajadores</h5>
                        <p class="text-muted">Gestiona los trabajadores de esta finca.</p>
                        <a href="{{ route('trabajadores.index', $finca) }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Ver Trabajadores</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-2">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">📋</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Actividades</h5>
                        <p class="text-muted">Programa y controla actividades agrícolas.</p>
                        <a href="{{ route('actividades.index', $finca) }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Ver Actividades</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-3">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">🧪</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Insumos</h5>
                        <p class="text-muted">Controla fertilizantes, abonos y venenos.</p>
                        <a href="{{ route('insumos.index', $finca) }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Ver Insumos</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-4">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">💵</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Pagos</h5>
                        <p class="text-muted">Registra y controla los pagos de los trabajadores.</p>
                        <a href="{{ route('pagos.index', $finca) }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Ver Pagos</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-5">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">💰</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Financiero</h5>
                        <p class="text-muted">Registra ingresos y gastos de la finca.</p>
                        <a href="{{ route('financiero.index', $finca) }}" class="btn w-100 text-white"
                           style="background: #1a3a2a;">Ver Finanzas</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-6">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">📊</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Reportes</h5>
                        <p class="text-muted">Visualiza estadísticas y productividad.</p>
                        <a href="{{ route('reportes.index', $finca) }}" class="btn w-100 fw-bold"
                           style="background: #c9a84c; color: #1a3a2a;">Ver Reportes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 card-hover anim-fade-up delay-1">
                    <div class="card-body text-center p-4">
                        <div style="font-size: 3rem;">☕</div>
                        <h5 class="fw-bold mt-2" style="color: #1a3a2a;">Cosecha</h5>
                        <p class="text-muted">Registra kilos por trabajador mañana y tarde.</p>
                        <a href="{{ route('cosecha.index', $finca) }}" class="btn w-100 text-white fw-bold"
                        style="background: #1a3a2a;">Ver Cosecha</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>