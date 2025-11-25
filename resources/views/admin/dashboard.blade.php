@extends('layouts.app')

@vite(['resources/js/dashboard.js'])

<style>
    #chartBodegasEstado,
    #chartMaterialesEstado,
    #chartBodegas,
    #chartMateriales {
        width: 100%;
        height: 350px; /* ALTURA OBLIGATORIA */
    }

    .chart-scroll {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 10px;
    }
</style>


@section('content')
    <div class="page" data-seccion="dashboard">
        <div class="container">
            <h1 class="mb-4">Dashboard General</h1>

            {{-- Tarjetas --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5>Bodegas Activas</h5>
                            <h2 id="bodegasActivas">0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h5>Bodegas Inactivas</h5>
                            <h2 id="bodegasInactivas">0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5>Materiales Activos</h5>
                            <h2 id="materialesActivos">0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-dark">
                        <div class="card-body">
                            <h5>Materiales Inactivos</h5>
                            <h2 id="materialesInactivos">0</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gráficos PIE / DONUT --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Bodegas (Activas vs Inactivas)</div>
                        <div class="card-body">
                            <div id="chartBodegasEstado"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Materiales (Activos vs Inactivos)</div>
                        <div class="card-body">
                            <div id="chartMaterialesEstado"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gráficos DETALLE por referencia/item --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Bodegas por Referencia</div>
                        <div class="card-body">
                            <div class="chart-scroll">
                                <div id="chartBodegas"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Materiales por Item</div>
                        <div class="card-body">
                            <div class="chart-scroll">
                                <div id="chartMateriales"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
