@extends('layouts.admin.master')

@section('title', $title)

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/buttons.datatable.min.css')}}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <style>
        button.dt-button, div.dt-button, a.dt-button{
            background-image: none
        }
        .form-check .form-check-input {
            width: 18px;
            height: 18px;
            border-color: var(--chart-dashed-border);
        }
    </style>
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb :admin="true">{{$title}}</x-breadcrumb>

    <x-table>{!! $dataTable->table() !!}</x-table>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script> --}}

    
    {{-- <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script> --}}
    <script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>

    {!! $dataTable->scripts() !!}

    
@endsection