@extends('layouts.member.master')

@section('title', 'Dashboard')

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}"> --}}
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>{{__('Dashboard')}}</x-breadcrumb>

    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xxl-4 col-sm-6 box-col-6">
                <div class="card profile-box">
                    <div class="card-body">
                        <div class="d-flex media-wrapper justify-content-between">
                            <div class="flex-grow-1">
                                <div class="greeting-user">
                                    <h2 class="f-w-600">{{__('Selamat Datang')}} {{ \Illuminate\Support\Str::title(auth()->user()->name ?? '') }}!</h2>
                                    <p>{{__('Berikut data terbaru dari akun anda')}}</p>
                                    <div class="whatsnew-btn">
                                        <a class="btn btn-outline-white" href="{{ route('app.dashboard.index') }}" target="_blank">{{__('View Profile')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="clockbox"><svg id="clock" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 600 600">
                                        <g id="face">
                                            <circle class="circle" cx="300" cy="300" r="253.9"></circle>
                                            <path class="hour-marks"
                                                d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6">
                                            </path>
                                            <circle class="mid-circle" cx="300" cy="300" r="16.2"></circle>
                                        </g>
                                        <g id="hour">
                                            <path class="hour-hand" d="M300.5 298V142"></path>
                                            <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                                        </g>
                                        <g id="minute">
                                            <path class="minute-hand" d="M300.5 298V67"> </path>
                                            <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                                        </g>
                                        <g id="second">
                                            <path class="second-hand" d="M300.5 350V55"></path>
                                            <circle class="sizing-box" cx="300" cy="300" r="253.9">
                                            </circle>
                                        </g>
                                    </svg></div>
                                <div class="badge f-10 p-0" id="txt"></div>
                            </div>
                        </div>
                        <div class="cartoon"><img class="img-fluid" src="{{ asset('assets/images/dashboard/cartoon.svg') }}"
                                alt="vector women with leptop">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-3">
                <div class="row">
                    <div class="col-xl-12">
                        <x-widget.card color="success" jumlah="{{ $totalLelang }}" :icon="asset('assets/svg/icon-sprite.svg#c-customer')" :href="route('admin.lelang-sirup.index')">{{__('Lelang')}}</x-widget.card>
                        
                        <x-widget.card color="success" jumlah="{{ $totalTender }}" :icon="asset('assets/svg/icon-sprite.svg#c-customer')" :href="route('admin.tender-lpse.index')">{{__('Tender LPSE')}}</x-widget.card>
                    </div>
                </div>
            </div>
            <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-3">
                <div class="row">
                    <div class="col-xl-12">
                        <a href="{{route('app.tender-kata-kunci.index')}}">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round warning">
                                            <div class="bg-round"><svg>
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#c-profit') }}"> </use>
                                                </svg><svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg></div>
                                        </div>
                                        <div>
                                            <h4> <span class="counter" data-target="{{$tenderkeyword}}">0</span></h4><span
                                                class="f-light">Tender by Keyword</span>
                                        </div>
                                    </div>
                                    <div class="font-danger f-w-500"><i class="bookmark-search me-1"
                                            data-feather="trending-down"></i><span class="txt-danger">-20%</span></div>
                                </div>
                            </div>
                        </a>
                        
                        <div class="col-xl-12">
                            <a href="{{route('app.fokus-paket.index')}}">
                                <div class="card widget-1">
                                    <div class="card-body">
                                        <div class="widget-content">
                                            <div class="widget-round primary">
                                                <div class="bg-round"><svg class="fill-primary">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#c-invoice') }}">
                                                        </use>
                                                    </svg><svg class="half-circle svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div>
                                                <h4>{{ $totalFokus }}</h4><span
                                                    class="f-light">Fokus Paket</span>
                                            </div>
                                        </div>
                                        <div class="font-success f-w-500"><i class="bookmark-search me-1"
                                                data-feather="trending-up"></i><span class="txt-success">+50%</span></div>
                                    </div>
                                </div>
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-auto col-xl-4 col-sm-6 box-col-4 ord-xl-5 box-ord-5">
                <x-widget.visitor></x-widget.visitor>
            </div>

            <div class="col-xxl-9 col-lg-6 box-col-6 ord-xl-2 ord-md-3 box-ord-2">
                <x-widget.grafiklpse :totalTender="$totalTender" :totalLelang="$totalLelang"></x-widget.grafiklpse>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-6 box-col-6 ord-xl-2 ord-md-3 box-ord-2">
                <x-widget.masaaktif :list="false" :masaberlaku="$masaberlaku"></x-widget.masaakt>
                <x-widget.referal :list="false" :username="$username"></x-widget.referal>
                <x-widget.komisi :list="false" :totalkomisi="$totalkomisi"></x-widget.komisi>
            </div>
            <div class="col-xxl-6 col-lg-6 ord-xl-10 ord-md-8 box-ord-7 box-col-6">
                <x-widget.history :items="$errorsLog"></x-widget.history>
            </div>
            <div class="col-xxl-6 col-lg-8 ord-xl-6 ord-md-6 box-ord-6 box-col-8e">
                <x-widget.toplpse :datas="$toplpse" :href="route('app.lpse.index')"></x-widget.toplpse>
            </div>
            
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script>
        window.appConfig = {
            invoices: {{ \Illuminate\Support\Js::from($dataInvoices) }},
            paidInvoices: {{ \Illuminate\Support\Js::from($dataPaidInvoices) }},
            dataVisitor: {{ \Illuminate\Support\Js::from($dataVisitor) }},
            dataScrapeLPSE: {{ \Illuminate\Support\Js::from($dataScrapeLPSE) }},
            dataScrapeSirup: {{ \Illuminate\Support\Js::from($dataScrapeSirup) }},
            tanggalAxis: {{ \Illuminate\Support\Js::from($tanggalAxis) }},
        };
    </script>
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/clock.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/notify/index.js') }}"></script> --}}
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.select.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/select.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
@endsection
