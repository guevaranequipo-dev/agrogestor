<x-app-layout>
    <x-slot name="header">
        <h2>Nuevo Pago</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <x-breadcrumb :links="[
                'Mis Fincas'  => route('fincas.index'),
                $finca->nombre => route('fincas.show', $finca),
                'Pagos'       => route('pagos.index', $finca),
                'Nuevo Pago'  => '#',
            ]"/>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm anim-fade-up">
                        <div class="card-header text-white fw-bold"
                             style="background: #1a3a2a;">
                            💵 Registrar Nuevo Pago
                        </div>
                        <div class="card-body">

                            <form action="{{ route('pagos.store', $finca) }}" method="POST" id="app">
                                @csrf

                                <formulario-pago
                                    :trabajadores="{{ json_encode($trabajadores) }}"
                                    :inicial="{{ json_encode([]) }}">
                                </formulario-pago>

                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('pagos.index', $finca) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn text-white fw-bold"
                                            style="background: #1a3a2a;">Guardar Pago</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>