@extends('layouts.admin.master')

@section('title', 'Edit LPSE')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>{{__('Pengaturan')}}</x-breadcrumb>

    {{-- Form --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3 custom-input" id="userForm" action="{{ route('admin.applikasi.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Edit Pengaturan')}}</h4>
                    </div>
                    <div class="card-body">
                            @csrf
                            @method('PUT')
                            @include('admin.pengaturan.form')
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" name="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        <a href="{{ route('admin.lpse.index')}}" class="btn btn-danger">{{ __('Batal')}}</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
@endsection