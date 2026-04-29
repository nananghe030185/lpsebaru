@extends('layouts.admin.master')

@section('title', 'Tambah Pengumuman')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Pengumuman</x-breadcrumb>

    {{-- Form --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3 custom-input" id="userForm" action="{{ route('admin.pengumuman.store', $pengumuman->id) }}" method="POST">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Pengumuman</h4>
                    </div>
                    <div class="card-body">
                            @csrf
                            @method('POST')
                            @include('admin.pengumuman.form')
                    </div>
                    <div class="card-footer text-end">
                         <x-form.buttonsimpan></x-form.buttonsimpan>
                        <x-form.buttonbatal :href="route('admin.pengumuman.index')"></x-form.buttonbatal>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
@endsection