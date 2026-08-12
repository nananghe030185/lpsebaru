@extends('layouts.admin.master')

@section('title', 'Create Tag')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <x-breadcrumb parent="Tags" route="{{ route('admin.tag.index') }}">Create</x-breadcrumb>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Tag</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 custom-input" id="tagForm" action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('admin.tag.fields')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <!-- calendar js-->
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/bookmark/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-validation/validation.js') }}"></script>
@endsection
