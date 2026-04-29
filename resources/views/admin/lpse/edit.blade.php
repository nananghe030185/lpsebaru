@extends('layouts.admin.master')

@section('title', 'Edit LPSE')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>LPSE</x-breadcrumb>

    {{-- Form --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3 custom-input" id="userForm" action="{{ route('admin.lpse.update', $lpse->id) }}" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit LPSE</h4>
                    </div>
                    <div class="card-body">
                            @csrf
                            @method('PUT')
                            @include('admin.lpse.form')
                    </div>
                    <div class="card-footer text-end">
                        <x-form.buttonsimpan></x-form.buttonsimpan>
                        <x-form.buttonbatal :href="route('admin.lpse.index')"></x-form.buttonbatal>
                        
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