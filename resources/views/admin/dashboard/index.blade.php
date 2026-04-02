@extends('layouts.admin.master')


@section('title', 'Dashboard')

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}"> --}}
@endsection

@section('pengumuman', 'ini pengumumannnnnnnnnnnnnnnnnnnn')
@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Dashboard</x-breadcrumb>

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
                                        {{-- <a class="btn btn-outline-white" href="{{ route('admin.user_profile') }}" target="_blank">View Profile</a> --}}
                                        <a class="btn btn-outline-white" href="{{ route('admin.dashboard') }}" target="_blank">{{__('View Profile')}}</a>
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
                        <a href="{{route('admin.lelang-sirup.index')}}">
                            <div class="card widget-1">
                                <div class="card-body">
                                    <div class="widget-content">
                                        <div class="widget-round secondary">
                                            <div class="bg-round"><svg>
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#c-revenue') }}"> </use>
                                                </svg><svg class="half-circle svg-fill">
                                                    <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                                </svg></div>
                                        </div>
                                        <div>
                                            <h4><span class="counter" data-target={{$lelang}}>0</span></h4><span
                                                class="f-light">{{__('Lelang')}}</span>
                                        </div>
                                    </div>
                                    <div class="font-success f-w-500"><i class="bookmark-search me-1"
                                            data-feather="trending-up"></i><span class="txt-success">+70%</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{route('admin.tender-lpse.index')}}">
                            <div class="col-xl-12">
                                <div class="card widget-1">
                                    <div class="card-body">
                                        <div class="widget-content">
                                            <div class="widget-round success">
                                                <div class="bg-round"><svg>
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#c-customer') }}">
                                                        </use>
                                                    </svg><svg class="half-circle svg-fill">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div>
                                                <h4> <span class="counter" data-target={{$tender}}>0</span></h4><span
                                                    class="f-light">Tender LPSE</span>
                                            </div>
                                        </div>
                                        <div class="font-danger f-w-500"><i class="bookmark-search me-1"
                                                data-feather="trending-down"></i><span class="txt-danger">-40%</span></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-auto col-xl-8 col-sm-8 box-col-12 ord-xl-5 box-ord-5">
                <div class="card">
                    <div class="card-header card-no-border pb-2">
                        <div class="header-top">
                            <h5>Visitors</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle"
                                        id="visitorButton" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitorButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body visitor-chart pt-0">
                        <div class="common-flex">
                            <h6><span class="counter" data-target="98736">0</span>K</h6>
                            <div class="d-flex">
                                <p>( <span class="txt-success f-w-500 me-1">+0.4%</span>Than last week)</p>
                            </div>
                        </div>
                        <div id="visitor_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-sm-6 ord-xl-1 ord-md-1 box-ord-1 box-col-6">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Top User</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle"
                                        id="customerButton" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customerButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body main-customer-table px-0 pt-0">
                        <div class="recent-table table-responsive custom-scrollbar">
                            <table class="table" id="top-customer">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td> </td>
                                            <td>
                                                <div class="d-flex"><img class="img-fluid img-40 rounded-circle me-2"
                                                        src="{{ asset('assets/images/dashboard/user/2.jpg') }}"
                                                        alt="user">
                                                    <div class="img-content-box">
                                                        {{-- <a class="f-w-500" href="{{ route('admin.list_products') }}">Jane Cooper</a> --}}
                                                        <a class="f-w-500" href="{{ route('admin.dashboard') }}">Jane Cooper</a>
                                                        <p class="mb-0 f-light">#452140</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$user->email}}</td>
                                            <td class="f-w-500 txt-success">{{$user->email}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 col-lg-6 box-col-6 ord-xl-2 ord-md-3 box-ord-2">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Sales Statistical Overview</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown custom-dropdown"><button class="btn dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Year</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#!">Day</a></li>
                                        <li><a class="dropdown-item" href="#!">Month</a></li>
                                        <li><a class="dropdown-item" href="#!">Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row m-0 overall-card">
                            <div class="col-12 p-0">
                                <div class="chart-right">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card-body p-0 statistical-card">
                                                <ul class="d-flex m-b-15">
                                                    <li>
                                                        <h5 class="counter" data-target="19897">0</h5><span
                                                            class="f-light">Total Cost</span>
                                                    </li>
                                                    <li>
                                                        <h5> $<span class="counter" data-target="849058">0</span></h5>
                                                        <span class="f-light">Total Revenue</span>
                                                    </li>
                                                </ul>
                                                <div class="current-sale-container">
                                                    <div id="chart-currently"></div>
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
            <div class="col-xl-3 col-md-6 ord-xl-3 ord-md-4 box-ord-3">
                <div class="card monthly-header">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Monthly Target</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle"
                                        id="monthlyButton" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="monthlyButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="monthly-target">
                            <div class="position-relative" id="monthly_target"></div>
                        </div>
                        <div class="target-content">
                            <p>Revenue Surges! Today's earnings soar to $3653, marking an impressive uptick
                                from last month. Keep the momentum going!</p>
                            <div class="common-box">
                                <ul class="common-flex">
                                    <li>
                                        <h6>Revenue</h6><span class="common-space badge badge-light-success"> <i
                                                class="me-1" data-feather="trending-up"></i>$20k</span>
                                    </li>
                                    <li>
                                        <h6>Target</h6><span class="common-space badge badge-light-danger"><i
                                                class="me-1" data-feather="trending-down"></i>$16k</span>
                                    </li>
                                    <li>
                                        <h6>Today</h6><span class="common-space badge badge-light-success"><i
                                                class="me-1" data-feather="trending-up"></i>$1.6k</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 ord-xl-4 ord-md-5 box-ord-4">
                <div class="card activity-log notification main-timeline">
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
                </div>
            </div>
            <div class="col-xxl-7 col-lg-8 ord-xl-6 ord-md-6 box-ord-6 box-col-8e">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Top LPSE</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle" id="recentButton"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="recentButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 common-option">
                        <div class="recent-table table-responsive currency-table recent-order-table custom-scrollbar">
                            <table class="table" id="main-recent-order">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama LPSE</th>
                                        <th>Total Paket</th>
                                        <th>Total Pagu</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($toplpse as $lpse)
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="currency-icon warning"><img class="img-fluid"
                                                            src="{{ asset('assets/images/dashboard-2/order/sub-product/16.png') }}"
                                                            alt=""></div>
                                                    <div> 
                                                        {{-- <a class="f-14 mb-0 f-w-500 c-light" href="{{ route('admin.dashboard') }}">Bag</a> --}}
                                                        <a class="f-14 mb-0 f-w-500 c-light" href="{{$lpse->link}}">{{$lpse->nama_lpse}}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{number_format($lpse->jumlah_paket)}}</td>
                                            <td>{{App\Helpers\TableHelper::nominal_simple($lpse->jumlah_pagu)}}</td>
                                            
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-sm-6 box-col-4 ord-xl-7 ord-md-2 box-ord-7">
                <div class="card buy-card"><img class="img-fluid"
                        src="{{ asset('assets/images/dashboard/purchase1.png') }}" alt="vector mens with laptop">
                    <div class="card-body">
                        <h6 class="mb-3">Buy <a class="txt-info" href="#!">Pro Account </a>to Explore
                            Premium Features</h6><a class="purchase-btn btn btn-primary btn-hover-effect f-w-500"
                            href="https://1.envato.market/3GVzd" target="_blank">Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 col-lg-6 ord-xl-9 ord-md-7 box-ord-7 box-col-6">
                <div class="card sales-report">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Sales Report</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle" id="salesButton"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <ul class="balance-data">
                            <li><span class="circle bg-primary"></span><span class="c-light ms-1">Orders</span></li>
                            <li><span class="circle bg-warning"> </span><span class="c-light ms-1">Earnings</span></li>
                            <li><span class="circle bg-secondary"> </span><span class="c-light ms-1">Refunds</span></li>
                        </ul>
                        <div id="sale_report"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-6 ord-xl-10 ord-md-8 box-ord-7 box-col-6">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5>Manage Appointments</h5>
                            <div class="card-header-right-icon">
                                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle" id="manageButton"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="icon-more-alt"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="manageButton"><a
                                            class="dropdown-item" href="#!">Today</a><a class="dropdown-item"
                                            href="#!">Tomorrow</a><a class="dropdown-item"
                                            href="#!">Yesterday</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <ul class="appointments-wrapper">
                            <li class="d-flex align-items-start"><span>12:30</span>
                                <div class="bg-lighter-primary"></div>
                                <div class="main-box">
                                    <div class="mb-2"> <span>Participating Meeting</span><span class="c-o-light">There
                                            are many variations of passages
                                            available</span><span class="txt-primary">2:00 PM - 4:30
                                            PM</span></div>
                                    <div><button class="btn btn-primary">General</button></div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start"><span>11:30</span>
                                <div class="bg-lighter-warning"></div>
                                <div class="main-box">
                                    <div> <span>Customer Support issues</span></div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start"><span>10:25</span>
                                <div class="bg-lighter-dark"></div>
                                <div class="main-box">
                                    <div> <span>Read the report</span></div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start"><span>09:00</span>
                                <div class="bg-lighter-success"></div>
                                <div class="main-box">
                                    <div> <span>Development issue #26</span></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
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
