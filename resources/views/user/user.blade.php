@extends('layouts.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="table-user">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $userFull->id }}</td>
                        <td>{{ $userFull->profile->name }}</td>
                        <td>{{ $userFull->email }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="showUsr({{$userFull->id}})" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="upUsr({{$userFull->id}})" data-toggle="tooltip" data-placement="top" title="Modificar usuario"><i class="fas fa-pencil-alt"></i></button>
                            <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="deleteUsr({{$userFull->id}})" data-toggle="tooltip" data-placement="top" title="Quitar usuario"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('user.modal')

@endsection

@push('styles')
    <!-- Style Datatables -->
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .select2-selection__choice {
        height: 25px;
        line-height: 25px;
        padding-right: 12px !important;
        padding-left: 12px !important;
        background-color: #5897FB !important;
        color: #FFF !important;
        border: none !important;
        border-radius: 3px !important;
        }
        .select2-selection__choice__remove {
            float: left;
            margin-right: 2px;
            margin-left: 0px;
            color: #FFF !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/scriptsApp/user.js') }}" type="text/javascript"></script>
@endpush
