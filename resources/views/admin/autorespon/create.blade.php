@extends('layouts.admin.master')

@section('title', 'Auto Respon')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb :admin="true" parent="Auto Respon" route="{{ route('admin.auto-respon.index') }}">Create</x-breadcrumb>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                 <form class="row g-3" action="{{ route('admin.auto-respon.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card custom-input">
                        <div class="card-header">
                            <h4>Tambah Auto Respon</h4>
                        </div>
                        <div class="card-body">
                                @csrf
                                {{-- @method('PUT') --}}
                                @include('admin.autorespon.form')
                        </div>
                        <div class="card-footer text-end d-inline-flex gap-1 justify-content-end">
                            <x-form.buttonsimpan></x-form.buttonsimpan>
                            <x-form.buttonbatal href="{{ route('admin.auto-respon.index')}}"></x-form.buttonbatal>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/editors/quill.js') }}"></script>
    <script src="{{ asset('assets/js/editors/custom-quill.js')}}"></script>
    <script src="{{ asset('assets/js/custom-add-product5.js') }}"></script>
    <script src="{{ asset('assets/js/bookmark/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-validation/validation.js') }}"></script>
@endsection