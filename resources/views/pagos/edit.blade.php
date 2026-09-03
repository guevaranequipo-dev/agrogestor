<x-app-layout>
    <x-slot name="header">
        <h2>Editar Pago</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <x-breadcrumb :links="[
                'Mis Fincas'  => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Pagos'       => route('pagos.index', $finca),
                'Editar Pago' => '#',
            ]"/>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm anim-fade-up">
                        <div class="card-header text-white fw-bold"
                             style="background: #1a3a2a;">
                            💵 Editar Pago
                        </div>
                        <div class="card-body">

                            <form action="{{ route('pagos.update', [$finca, $pago]) }}" method="POST" id="app">
                                @csrf
                                @method('PUT')

                                <formulario-pago
                                    :trabajadores="{{ json_encode($trabajadores) }}"
                                    :inicial="{{ json_encode([
                                        'trabajador_id'        => $pago->trabajador_id,
                                        'tipo_pago'            => $pago->tipo_pago,
                                        'fecha'                => \Carbon\Carbon::parse($pago->fecha)->format('Y-m-d'),
                                        'dias_trabajados'      => $pago->dias_trabajados,
                                        'valor_dia'            => $pago->valor_dia,
                                        'descripcion_contrato' => $pago->descripcion_contrato,
                                        'valor_contrato'       => $pago->valor_contrato,
                                        'cantidad_recolectada' => $pago->cantidad_recolectada,
                                        'precio_por_kg'        => $pago->precio_por_kg,
                                    ]) }}">
                                </formulario-pago>

                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('pagos.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-warning fw-bold">Actualizar Pago</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>