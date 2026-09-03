<x-app-layout>
    <x-slot name="header">
        <h2>Módulo Financiero</h2>
    </x-slot>
    <x-breadcrumb :links="[
        'Mis Fincas' => route('fincas.index'),
        'Finanzas' => '',
    ]"/>

    <div class="container py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Volver y título --}}
        <div class="d-flex justify-content-between align-items-center mb-4 anim-fade-up">
            <div>
                <a href="{{ route('fincas.show', $finca) }}" class="btn btn-secondary btn-sm mb-2">
                    ← Volver a {{ $finca->nombre }}
                </a>
                <h4 style="color: #1a3a2a;">💰 Finanzas de {{ $finca->nombre }}</h4>
            </div>
        </div>

        {{-- Resumen financiero --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-1">
                    <p class="text-muted mb-1">Total Ingresos</p>
                    <h3 class="fw-bold text-success">${{ number_format($totalIngresos, 0) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-2">
                    <p class="text-muted mb-1">Total Gastos</p>
                    <h3 class="fw-bold text-danger">${{ number_format($totalGastos, 0) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3 card-hover anim-fade-up delay-3">
                    <p class="text-muted mb-1">Balance</p>
                    <h3 class="fw-bold" style="color: {{ $balance >= 0 ? '#1a3a2a' : '#dc3545' }}">
                        ${{ number_format($balance, 0) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Ingresos --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm anim-fade-left">
                    <div class="card-header d-flex justify-content-between align-items-center"
                         style="background: #1a3a2a; color: white;">
                        <span>📈 Ingresos</span>
                        <a href="{{ route('financiero.createIngreso', $finca) }}"
                           class="btn btn-sm" style="background: #c9a84c; color: #1a3a2a; font-weight: 600;">
                            + Nuevo
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($ingresos->isEmpty())
                            <p class="text-muted text-center p-3">No hay ingresos registrados.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Categoría</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ingresos as $ingreso)
                                            <tr>
                                                <td>{{ $ingreso->descripcion }}</td>
                                                <td>
                                                    @if($ingreso->categoria)
                                                        <span class="badge bg-success">{{ $ingreso->categoria }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</td>
                                                <td><strong>${{ number_format($ingreso->monto, 0) }}</strong></td>
                                                <td>
                                                    <a href="{{ route('financiero.editIngreso', [$finca, $ingreso]) }}"
                                                       class="btn btn-warning btn-sm">✏️</a>
                                                    <form action="{{ route('financiero.destroyIngreso', [$finca, $ingreso]) }}"
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar este ingreso?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">🗑️</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Gastos --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm anim-fade-right">
                    <div class="card-header d-flex justify-content-between align-items-center"
                         style="background: #742a2a; color: white;">
                        <span>📉 Gastos</span>
                        <a href="{{ route('financiero.createGasto', $finca) }}"
                           class="btn btn-sm" style="background: #c9a84c; color: #1a3a2a; font-weight: 600;">
                            + Nuevo
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($gastos->isEmpty())
                            <p class="text-muted text-center p-3">No hay gastos registrados.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Categoría</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gastos as $gasto)
                                            <tr>
                                                <td>{{ $gasto->descripcion }}</td>
                                                <td>
                                                    @if($gasto->categoria)
                                                        <span class="badge bg-danger">{{ $gasto->categoria }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                                                <td><strong>${{ number_format($gasto->monto, 0) }}</strong></td>
                                                <td>
                                                    <a href="{{ route('financiero.editGasto', [$finca, $gasto]) }}"
                                                       class="btn btn-warning btn-sm">✏️</a>
                                                    <form action="{{ route('financiero.destroyGasto', [$finca, $gasto]) }}"
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Eliminar este gasto?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">🗑️</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>