@extends('layouts.admin.master')

@section('title', 'Edit User')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/dropzone.min.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Edit User</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active"> Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    
    
    <div class="container-fluid">        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit User</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-xl-5 g-3">
                            <div class="col-xxl-3 col-xl-4 box-col-4e sidebar-left-wrapper">
                                <ul class="sidebar-left-icons nav nav-pills" id="add-product-pills-tab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" id="detail-akun-tab"
                                            data-bs-toggle="pill" href="#detail-akun" role="tab"
                                            aria-controls="detail-akun" aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use
                                                            href="{{ asset('assets/svg/icon-sprite.svg#product-detail') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Akun</h6>
                                                <p>Edit Akun anda</p>
                                            </div>
                                        </a></li>
                                    <li class="nav-item"> <a class="nav-link" id="gallery-product-tab" data-bs-toggle="pill"
                                            href="#gallery-product" role="tab" aria-controls="gallery-product"
                                            aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use
                                                            href="{{ asset('assets/svg/icon-sprite.svg#product-gallery') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Image User</h6>
                                                <p>Upload Foto Profile anda</p>
                                            </div>
                                        </a></li>
                                    <li class="nav-item"> <a class="nav-link" id="category-product-tab"
                                            data-bs-toggle="pill" href="#category-product" role="tab"
                                            aria-controls="category-product" aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use
                                                            href="{{ asset('assets/svg/icon-sprite.svg#product-category') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Profile</h6>
                                                <p>Update Profile anda</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xxl-9 col-xl-8 box-col-8 position-relative">
                                <div class="tab-content custom-input" id="add-product-pills-tabContent">
                                    <div class="tab-pane fade show active" id="detail-akun" role="tabpanel"
                                        aria-labelledby="detail-akun-tab">
                                        <div class="sidebar-body">
                                            @include('admin.user.akun', ['user' => $user])
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="gallery-product" role="tabpanel"
                                        aria-labelledby="gallery-product-tab">
                                        <div class="sidebar-body common-form">
                                            @include('admin.user.image', ['user' => $user])
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="category-product" role="tabpanel"
                                        aria-labelledby="category-product-tab">
                                        <div class="sidebar-body common-form e-category">
                                            @include('admin.user.profile', ['user' => $user])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/select2/tagify.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select3-custom.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone/dropzone-script.js') }}"></script>

    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/bs-indeterminate.js') }}"></script>
@endsection
