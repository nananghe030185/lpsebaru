@extends('layouts.admin.master')

@section('title', 'Broadcast')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Telegram</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Broadcast</li>
                        <li class="breadcrumb-item active"> Telegram</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="email-wrap email-main-wrapper">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 box-col-12">
                    <div class="md-sidebar"> <a class="btn btn-primary md-sidebar-toggle" href="#!">email
                            filter</a>
                        <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                            <div class="email-left-aside">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="email-app-sidebar">
                                            <ul class="nav nav-pills main-menu email-category" id="email-pills-tab"
                                                role="tablist">
                                                <li class="nav-item"><a class="nav-link active" id="inbox-pill-tab"
                                                        data-bs-toggle="pill" href="#inbox-pill" role="tab"
                                                        aria-controls="inbox-pill" aria-selected="false"><svg
                                                            class="stroke-icon">
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#inbox') }}">
                                                            </use>
                                                        </svg>
                                                        <div>Member<span class="badge badge-light-primary">35</span>
                                                        </div>
                                                    </a></li>
                                                <li class="nav-item"><a class="nav-link" id="sent-pill-tab"
                                                        data-bs-toggle="pill" href="#sent-pill" role="tab"
                                                        aria-controls="sent-pill" aria-selected="false"><svg
                                                            class="stroke-icon">
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#sent') }}">
                                                            </use>
                                                        </svg>Non Member</a></li>
                                                <li class="nav-item"><a class="nav-link" id="starred-pill-tab"
                                                        data-bs-toggle="pill" href="#starred-pill" role="tab"
                                                        aria-controls="starred-pill" aria-selected="false"><svg
                                                            class="stroke-icon">
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}">
                                                            </use>
                                                        </svg>
                                                        <div>Semua Pengguna<span class="badge badge-light-primary">6</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" id="starred-pill-tab"
                                                        data-bs-toggle="pill" href="#starred-pill" role="tab"
                                                        aria-controls="starred-pill" aria-selected="false"><svg
                                                            class="stroke-icon">
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}">
                                                            </use>
                                                        </svg>
                                                        <div>Outer<span class="badge badge-light-primary">6</span>
                                                        </div>
                                                    </a>
                                                </li>

                                                <li class="nav-item"><a class="nav-link btn" data-bs-toggle="modal"
                                                        data-bs-target="#label-pill" href="#!"><i
                                                            class="fa fa-plus"></i>Add Label</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8 box-col-12">
                    <div class="email-right-aside">
                        <div class="card email-body email-list">
                            <div class="tab-content block-wrapper position-relative" id="email-pills-tabContent">
                                <div class="tab-pane fade show active" id="inbox-pill" role="tabpanel"
                                    aria-labelledby="inbox-pill-tab">
                                    <div class="mail-body-wrapper">
                                        <form action="{{ route('admin.broadcast.telegram.member') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-body">
                                                    @include('admin.broadcast.form', [
                                                        'editor' => 'editormember',
                                                        'toolbar' => 'toolbarmember',
                                                    ])
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sent-pill" role="tabpanel"
                                    aria-labelledby="sent-pill-tab">
                                    <div class="mail-body-wrapper">
                                       <form action="{{ route('admin.broadcast.telegram.nonmember') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-body">
                                                    @include('admin.broadcast.form',[
                                                        'editor' => 'editornonmember',
                                                        'toolbar' => 'toolbarnonmember',
                                                    ])
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="starred-pill" role="tabpanel"
                                    aria-labelledby="starred-pill-tab">
                                    <div class="mail-body-wrapper">
                                        <form action="{{ route('admin.broadcast.telegram.semua') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-body">
                                                    @include('admin.broadcast.form',[
                                                        'editor' => 'editorsemua',
                                                        'toolbar' => 'toolbarsemua',
                                                    ])
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="draft-pill" role="tabpanel"
                                    aria-labelledby="draft-pill-tab">
                                    <div class="mail-body-wrapper">
                                        <form action="{{ route('admin.broadcast.telegram.outer') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-body">
                                                    @include('admin.broadcast.form',[
                                                        'editor' => 'editorouter',
                                                        'toolbar' => 'toolbarouter',
                                                    ])
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="trash-pill" role="tabpanel"
                                    aria-labelledby="trash-pill-tab">
                                    <div class="mail-body-wrapper">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/blockui/custom-blockui1.js') }}"></script>
    <script src="{{ asset('assets/js/blockui/custom-freeze1.js') }}"></script>
    <script src="{{ asset('assets/js/trash.js') }}"></script>
    <script src="{{ asset('assets/js/letter-box/custom-mail-pagination.js') }}"></script>
    <script src="{{ asset('assets/js/letter-box/custom-usermail.js') }}"></script>
    <script src="{{ asset('assets/js/editors/quill.js') }}"></script>
    <script src="{{ asset('assets/js/editors/custom-quill.js') }}"></script>
    <script src="{{ asset('assets/js/print.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/custom-add-product5.js') }}"></script>

   
@endsection
