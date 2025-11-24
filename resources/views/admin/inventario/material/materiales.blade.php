@extends('layouts.app')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div id="all-table" data-api="materiales">
                    @include('admin.inventario.componentes.componentes_material.header_tabla_material')
                </div>
            </div>
        </div>
    </div>
@endsection
