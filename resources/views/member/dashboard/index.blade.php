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
                <x-widget.profile></x-widget.profile>
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
