@props(['users' => [], 'totalkomisi' => 0])
<div class="card">
    <div class="card-header card-no-border">
        <div class="header-top">
            <h5>Komisi</h5>
            <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle"
                    id="students_dropdown" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="icon-more-alt"></i></button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="students_dropdown">
                    <a class="dropdown-item" href="#">This Month</a><a
                        class="dropdown-item" href="#">Previous Month</a><a
                        class="dropdown-item" href="#">Last 3 Months</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="student-leader-wrapper">
            @foreach ($users as $n => $user)
                <div class="student-leader-content light-card">
                    <div class="d-flex align-items-center gap-2">
                        @php
                            $m = $n + 1;
                            $piala = "assets/images/dashboard-7/attendance/student-leader/rank-$m.svg";
                        @endphp
                        @if ($n < 3)
                            <img src="{{ asset($piala) }}" alt="rank-1">
                        @else
                            <h5>{{ $m }}<sup>th</sup></h5>
                        @endif
                        <img class="leader-img" src="{{ asset('assets/images/dashboard-7/attendance/student-leader/user-1.jpg') }}" alt="user 1">
                        <div class="leader-content-height">
                            <h6>
                                {{ $user->name }}
                                <span class="c-o-light f-14 f-w-400 ps-1">
                                    ({{ $user->jumlah_downline }} Downline) 
                                </span>
                            </h6>
                        </div>
                    </div><span class="f-14 txt-primary">{{ number_format($user->komisi) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card widget-hover overflow-hidden">
            <div class="card-header card-no-border pb-2">
                <h5>Total Komisi</h5>
            </div>
            <div class="card-body pt-0 count-student">
                <div class="school-wrapper">
                    <div class="school-header">
                        <h4 class="txt-primary">{{ number_format($totalkomisi)}}</h4>
                        <div class="d-flex gap-1 align-items-center flex-wrap pt-xxl-0 pt-2">
                            <i class="icon-arrow-up f-light"></i><span
                                class="f-w-500 f-light">+6.7%</span>
                        </div>
                    </div>
                    <div class="school-body"> 
                        <img src="{{ asset('assets/images/dashboard-8/payment-option/cash.svg') }}" alt="total students">
                        <div class="right-line">
                            <img src="{{ asset('assets/images/dashboard-7/line.png') }}" alt="line">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>