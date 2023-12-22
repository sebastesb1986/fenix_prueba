@extends('layouts.app')

@section('content')

<div class="card shadow mb-4">
    
    <div class="card-header py-3">
        <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="regUsr()" >
            <i class="fas fa-plus"></i> Registrar usuario
        </button>
    </div>

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
                    @foreach($userFull as $index =>$item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->profile->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="upUsr({{$item->id}})" data-toggle="tooltip" data-placement="top" title="Modificar usuario"><i class="fas fa-pencil-alt"></i></button>
                            <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="deleteUsr({{$item->id}})" data-toggle="tooltip" data-placement="top" title="Quitar usuario"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
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
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/scriptsApp/user.js') }}" type="text/javascript"></script>
@endpush
