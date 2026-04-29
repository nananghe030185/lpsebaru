@extends('layouts.admin.master')

@section('title', 'Edit KLPDI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>KLPDI</x-breadcrumb>

    {{-- Form --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3 custom-input" id="userForm" action="{{ route('admin.klpdi.update', $klpdi->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit KLPDI</h4>
                        </div>
                        <div class="card-body">
                                @csrf
                                @method('PUT')
                                @include('admin.klpdi.form')
                        </div>
                        <div class="card-footer text-end">
                            <x-form.buttonsimpan></x-form.buttonsimpan>
                            <x-form.buttonbatal href="{{ route('admin.klpdi.index')}}"></x-form.buttonbatal>
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
    <script src="{{ asset('assets/js/custom-add-product5.js') }}"></script>
    <script src="{{ asset('assets/js/bookmark/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-validation/validation.js') }}"></script>
@endsection