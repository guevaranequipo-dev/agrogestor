<x-app-layout>
    <x-slot name="header">
        <h2>Reportes</h2>
    </x-slot>

    @vite(['resources/css/pages/reportes.css', 'resources/js/pages/reportes.js'])

    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('fincas.show', $finca) }}" class="btn btn-secondary btn-sm mb-2">
                    ← Volver a {{ $finca->nombre }}
                </a>
                <h4 style="color: #1a3a2a;">📊 Reportes de {{ $finca->nombre }}</h4>
            </div>
        </div>

        {{-- Resumen general --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.1s">
                    <div style="font-size: 2rem;">👷</div>
                    <p class="text-muted mb-1 mt-1">Trabajadores</p>
                    <h3 class="fw-bold counter" style="color: #1a3a2a;"
                        data-target="{{ $totalTrabajadores }}">0</h3>
                    <small class="text-success">{{ $trabajadoresActivos }} activos</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.2s">
                    <div style="font-size: 2rem;">📋</div>
                    <p class="text-muted mb-1 mt-1">Actividades</p>
                    <h3 class="fw-bold counter" style="color: #1a3a2a;"
                        data-target="{{ $actividadesPendientes + $actividadesEnProgreso + $actividadesCompletadas }}">0</h3>
                    <small class="text-success">{{ $actividadesCompletadas }} completadas</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.3s">
                    <div style="font-size: 2rem;">🧪</div>
                    <p class="text-muted mb-1 mt-1">Insumos</p>
                    <h3 class="fw-bold counter" style="color: #1a3a2a;"
                        data-target="{{ $totalInsumos }}">0</h3>
                    <small class="text-muted">registrados</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.4s">
                    <div style="font-size: 2rem;">💵</div>
                    <p class="text-muted mb-1 mt-1">Total Pagado</p>
                    <h3 class="fw-bold counter" style="color: #1a3a2a;"
                        data-target="{{ $totalPagado }}"
                        data-format="money">$0</h3>
                    <small class="text-muted">en pagos</small>
                </div>
            </div>
        </div>

        {{-- Balance financiero --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.5s">
                    <p class="text-muted mb-1">Total Ingresos</p>
                    <h3 class="fw-bold text-success counter"
                        data-target="{{ $totalIngresos }}"
                        data-format="money">$0</h3>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="background: #1a3a2a;"
                             data-width="{{ $totalIngresos > 0 ? 100 : 0 }}"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.6s">
                    <p class="text-muted mb-1">Total Gastos</p>
                    <h3 class="fw-bold text-danger counter"
                        data-target="{{ $totalGastos }}"
                        data-format="money">$0</h3>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="background: #dc3545;"
                             data-width="{{ $totalIngresos > 0 ? min(100, ($totalGastos / $totalIngresos) * 100) : 0 }}"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3 stat-card" style="transition-delay: 0.7s">
                    <p class="text-muted mb-1">Balance</p>
                    <h3 class="fw-bold counter {{ $balance >= 0 ? 'balance-positive' : 'balance-negative' }}"
                        data-target="{{ abs($balance) }}"
                        data-format="money"
                        data-prefix="{{ $balance >= 0 ? '' : '-' }}">$0</h3>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            {{-- Gráfica ingresos vs gastos --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm card-chart">
                    <div class="card-header text-white fw-bold" style="background: #1a3a2a;">
                        📈 Ingresos vs Gastos (últimos 6 meses)
                    </div>
                    <div class="card-body">
                        <canvas id="graficaFinanciera"
                                height="120"
                                data-meses='@json($meses)'
                                data-ingresos='@json($ingresosPorMes)'
                                data-gastos='@json($gastosPorMes)'>
                        </canvas>
                    </div>
                </div>
            </div>

            {{-- Gráfica actividades --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm card-chart-right">
                    <div class="card-header text-white fw-bold" style="background: #1a3a2a;">
                        📋 Actividades por Estado
                    </div>
                    <div class="card-body">
                        <canvas id="graficaActividades"
                                height="200"
                                data-pendientes="{{ $actividadesPendientes }}"
                                data-en-progreso="{{ $actividadesEnProgreso }}"
                                data-completadas="{{ $actividadesCompletadas }}">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Pagos por tipo --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm table-card" style="transition-delay: 0.2s">
                    <div class="card-header text-white fw-bold" style="background: #1a3a2a;">
                        💵 Pagos por Tipo
                    </div>
                    <div class="card-body p-0">
                        @if($pagosPorTipo->isEmpty())
                            <p class="text-muted text-center p-3">No hay pagos registrados.</p>
                        @else
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pagosPorTipo as $pago)
                                        <tr>
                                            <td>
                                                @if($pago->tipo_pago == 'jornal')
                                                    <span class="badge bg-primary">Jornal</span>
                                                @elseif($pago->tipo_pago == 'contrato')
                                                    <span class="badge bg-warning text-dark">Contrato</span>
                                                @else
                                                    <span class="badge bg-success">Recolección</span>
                                                @endif
                                            </td>
                                            <td>{{ $pago->cantidad }}</td>
                                            <td><strong>${{ number_format($pago->total, 0) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Top trabajadores --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm table-card" style="transition-delay: 0.4s">
                    <div class="card-header text-white fw-bold" style="background: #1a3a2a;">
                        🏆 Top Trabajadores por Pagos
                    </div>
                    <div class="card-body p-0">
                        @if($topTrabajadores->isEmpty())
                            <p class="text-muted text-center p-3">No hay pagos registrados.</p>
                        @else
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Trabajador</th>
                                        <th>Pagos</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topTrabajadores as $i => $t)
                                        <tr>
                                            <td>
                                                @if($i == 0) 🥇
                                                @elseif($i == 1) 🥈
                                                @elseif($i == 2) 🥉
                                                @else {{ $i + 1 }}
                                                @endif
                                            </td>
                                            <td>{{ $t->trabajador->nombre }}</td>
                                            <td>{{ $t->cantidad_pagos }}</td>
                                            <td><strong>${{ number_format($t->total_pagado, 0) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>