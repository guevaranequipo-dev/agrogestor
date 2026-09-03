<x-app-layout>
    <x-slot name="header">
        <h2>Detalle de Semana</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <x-breadcrumb :links="[
                'Mis Fincas'   => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Cosecha'      => route('cosecha.index', $finca),
                'Semana'       => '#',
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

            {{-- Header de la semana --}}
            <div class="p-4 rounded-3 mb-4 anim-fade-up"
                 style="background: linear-gradient(135deg, #1a3a2a, #2d6a4f); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">
                            ☕ Semana del {{ \Carbon\Carbon::parse($semana->fecha_inicio)->format('d/m/Y') }}
                            al {{ \Carbon\Carbon::parse($semana->fecha_fin)->format('d/m/Y') }}
                        </h4>
                        <p class="mb-0" style="color: #c9a84c;">
                            Precio por kilo: <strong>${{ number_format($semana->precio_kilo, 0) }}</strong>
                        </p>
                    </div>
                    @if($semana->estado === 'abierta')
                        <span class="badge bg-success fs-6">Abierta</span>
                    @else
                        <span class="badge bg-secondary fs-6">Cerrada</span>
                    @endif
                </div>
            </div>

            {{-- Agregar trabajador --}}
            @if($semana->estado === 'abierta')
                <div class="card border-0 shadow-sm mb-4 anim-fade-up">
                    <div class="card-header fw-bold text-white" style="background: #1a3a2a;">
                        👷 Agregar Trabajador a la Semana
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cosecha.agregarTrabajador', [$finca, $semana]) }}" method="POST">
                            @csrf
                            <div class="d-flex gap-2">
                                <select name="trabajador_id" class="form-select" required>
                                    <option value="">-- Selecciona un trabajador --</option>
                                    @foreach($trabajadores as $trabajador)
                                        <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn text-white fw-bold"
                                        style="background: #1a3a2a; white-space: nowrap;">
                                    + Agregar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Tabla de registros --}}
            @if($registros->count() > 0)
                <form action="{{ route('cosecha.guardarRegistros', [$finca, $semana]) }}" method="POST">
                    @csrf
                    <div class="card border-0 shadow-sm mb-4 anim-fade-up">
                        <div class="card-header fw-bold text-white" style="background: #1a3a2a;">
                            📋 Registro de Kilos por Día
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr style="background: #f8f9fa;">
                                            <th style="min-width: 150px;">Trabajador</th>
                                            @foreach($dias as $dia)
                                                <th class="text-center" style="min-width: 130px;">
                                                    <div style="color: #1a3a2a; font-weight: 700;">
                                                        {{ $dia->translatedFormat('D') }}
                                                    </div>
                                                    <small class="text-muted">{{ $dia->format('d/m') }}</small>
                                                </th>
                                            @endforeach
                                            <th class="text-center" style="color: #1a3a2a;">Total kg</th>
                                            <th class="text-center" style="color: #c9a84c;">Total $</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trabajadores as $trabajador)
                                            @php
                                                $totalTrabajador = 0;
                                                $tieneRegistros = false;
                                            @endphp

                                            @foreach($dias as $dia)
                                                @php
                                                    $key = $trabajador->id . '_' . $dia->format('Y-m-d');
                                                    if(isset($registros[$key])) $tieneRegistros = true;
                                                @endphp
                                            @endforeach

                                            @if($tieneRegistros)
                                                <tr>
                                                    <td class="fw-bold" style="color: #1a3a2a;">
                                                        {{ $trabajador->nombre }}
                                                    </td>
                                                    @foreach($dias as $dia)
                                                        @php
                                                            $key = $trabajador->id . '_' . $dia->format('Y-m-d');
                                                            $registro = $registros[$key][0] ?? null;
                                                            if($registro) $totalTrabajador += $registro->total_kilos;
                                                        @endphp
                                                        <td class="p-1">
                                                            @if($registro)
                                                                <div class="d-flex flex-column gap-1">
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-text" style="font-size: 0.7rem; background: #e8f5e9;">☀️</span>
                                                                        @if($semana->estado === 'abierta')
                                                                            <input type="number"
                                                                                   name="registros[{{ $registro->id }}][kilos_manana]"
                                                                                   class="form-control form-control-sm"
                                                                                   value="{{ $registro->kilos_manana }}"
                                                                                   min="0" step="0.1"
                                                                                   style="font-size: 0.8rem;">
                                                                        @else
                                                                            <span class="form-control form-control-sm" style="font-size: 0.8rem;">{{ $registro->kilos_manana }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-text" style="font-size: 0.7rem; background: #fff3e0;">🌙</span>
                                                                        @if($semana->estado === 'abierta')
                                                                            <input type="number"
                                                                                   name="registros[{{ $registro->id }}][kilos_tarde]"
                                                                                   class="form-control form-control-sm"
                                                                                   value="{{ $registro->kilos_tarde }}"
                                                                                   min="0" step="0.1"
                                                                                   style="font-size: 0.8rem;">
                                                                        @else
                                                                            <span class="form-control form-control-sm" style="font-size: 0.8rem;">{{ $registro->kilos_tarde }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <small class="text-center text-muted" style="font-size: 0.7rem;">
                                                                        Total: {{ $registro->total_kilos }} kg
                                                                    </small>
                                                                </div>
                                                            @else
                                                                <span class="text-muted d-block text-center">-</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td class="text-center fw-bold" style="color: #1a3a2a;">
                                                        {{ number_format($totalTrabajador, 2) }} kg
                                                    </td>
                                                    <td class="text-center fw-bold" style="color: #c9a84c;">
                                                        ${{ number_format($totalTrabajador * $semana->precio_kilo, 0) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #1a3a2a; color: white;">
                                            <td colspan="{{ count($dias) + 1 }}" class="text-end fw-bold">
                                                Total General:
                                            </td>
                                            <td class="text-center fw-bold" style="color: #c9a84c;">
                                                ${{ number_format($semana->totalPagar(), 0) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($semana->estado === 'abierta')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cosecha.index', $finca) }}" class="btn btn-secondary">
                                ← Volver
                            </a>
                            <button type="submit" class="btn text-white fw-bold"
                                    style="background: #1a3a2a;">
                                💾 Guardar Registros
                            </button>
                        </div>
                    @endif
                </form>

            @else
                <div class="alert alert-info anim-fade-up">
                    No hay trabajadores agregados a esta semana. ¡Agrega uno arriba!
                </div>
            @endif

            {{-- Resumen por trabajador --}}
            @if($resumenTrabajadores->count() > 0)
                <div class="card border-0 shadow-sm mt-4 anim-fade-up">
                    <div class="card-header fw-bold text-white" style="background: #1a3a2a;">
                        📊 Resumen por Trabajador
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Trabajador</th>
                                    <th class="text-center">Total Kilos</th>
                                    <th class="text-center">Total a Pagar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resumenTrabajadores as $resumen)
                                    <tr>
                                        <td>{{ $resumen->trabajador->nombre }}</td>
                                        <td class="text-center fw-bold" style="color: #1a3a2a;">
                                            {{ number_format($resumen->total_kilos, 2) }} kg
                                        </td>
                                        <td class="text-center fw-bold" style="color: #c9a84c;">
                                            ${{ number_format($resumen->total_kilos * $semana->precio_kilo, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>