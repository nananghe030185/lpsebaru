@extends('layouts.admin.master')


@section('title', 'Dashboard')

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}"> --}}
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Dashboard</x-breadcrumb>

    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xxl-4 col-sm-6 box-col-6">
                <x-widget.profile></x-widget.profile>
            </div>
            <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-3">
                <div class="row">
                    <div class="col-xl-12">
                        <x-widget.card color="success" jumlah="{{ $member }}" :icon="asset('assets/svg/icon-sprite.svg#c-customer')" >{{__('Member')}}</x-widget.card>
                        
                        <x-widget.card color="success" jumlah="{{ $nonmember }}" :icon="asset('assets/svg/icon-sprite.svg#c-customer')" >{{__('Non Member')}}</x-widget.card>
                    </div>
                </div>
            </div>
            <div class="col-xxl-auto col-xl-3 col-sm-6 box-col-3">
                <div class="row">
                    <div class="col-xl-12">
                        <x-widget.card color="success" jumlah="{{ $lelang }}" :icon="asset('assets/svg/icon-sprite.svg#c-customer')" :href="route('admin.lelang-sirup.index')">{{__('Lelang')}}</x-widget.card>
                        
                        <x-widget.card color="success" jumlah="{{ $tender }}" :icon="asset('assets/svg/icon-sprite.svg#c-customer')" :href="route('admin.tender-lpse.index')">{{__('Tender LPSE')}}</x-widget.card>
                    </div>
                </div>
            </div>
            <div class="col-xxl-auto col-xl-8 col-sm-8 box-col-12 ord-xl-5 box-ord-5">
                <x-widget.visitor></x-widget.visitor>
            </div>
            <div class="col-xxl-4 col-sm-6 ord-xl-1 ord-md-1 box-ord-1 box-col-6">
                <x-widget.invoice  totalcancel="{{ $totalcancel }}" totalpending="{{ $totalpending }}" totalunpaid="{{ $totalunpaid }}" totalpaid="{{ $totalpaid }}"  totalinvoice="{{ $totalinvoice }}"  ></x-widget.invoice>
            </div>
            <div class="col-xxl-5 col-lg-6 box-col-6 ord-xl-2 ord-md-3 box-ord-2">
                <x-widget.komisi :users="$users" :totalkomisi="$totalkomisi"></x-widget.komisi>
            </div>
            <div class="col-xl-3 col-md-6 ord-xl-3 ord-md-4 box-ord-3">
                <x-widget.target></x-widget.target>
            </div>
            <div class="col-xl-5 col-md-6 ord-xl-4 ord-md-5 box-ord-4">
                {{-- <div class="card activity-log notification main-timeline">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Activity Log </h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle"
                                        id="activityButton" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="activityButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 dark-timeline basic-timeline">
                        <ul>
                            @foreach ($logs as $log)
                                <li class="d-flex">
                                    <div class="timeline-dot-primary"></div>
                                    <div class="w-100 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="mb-0 f-16">{{$log->message}}</p><span class="c-light">{{$log->created_at->format('H:i')}}</span>
                                        </div>
                                        <p class="mb-0 f-light pb-1">{{$log->message}}</p>
                                        <p class="date-content p-0">{{$log->created_at->format('d/m/Y')}}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div> --}}
            </div>
            <div class="col-xxl-7 col-lg-8 ord-xl-6 ord-md-6 box-ord-6 box-col-8e">
                {{-- <x-widget.toplpse></x-widget.toplpse> --}}
            </div>
            <div class="col-xxl-8 col-lg-6 ord-xl-9 ord-md-7 box-ord-7 box-col-6">
                <x-widget.grafiklpse></x-widget.grafiklpse>
            </div>
            <div class="col-xxl-4 col-lg-6 ord-xl-10 ord-md-8 box-ord-7 box-col-6">
                <x-widget.cashflow></x-widget.cashflow>
            </div>
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/clock.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
    <script src="{{ asset('assets/js/notify/index.js') }}"></script>
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
