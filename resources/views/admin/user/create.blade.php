@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('admin.user.store') }}" method="post">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <b>Users</b>
                            <a href="{{ route('admin.user.index') }}">Regresar</a>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
