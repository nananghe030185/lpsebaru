@props(['paid' => 0, 'totalpaid' => 0, 'unpaid' => 0, 'totalunpaid' =>0, 'cancel' => 0, 'totalcancel' => 0, 'pending' => 0, 'totalpending' => 0, 'totalinvoice' => 0])

<div class="card">
    <div class="card-header card-no-border pb-0">
        <div class="header-top">
            <h5>Invoice</h5>
            {{-- <div class="card-header-right-icon">
                <div class="dropdown icon-dropdown"><button class="btn dropdown-toggle"
                        id="gatewayEarning" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="icon-more-alt"></i></button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="gatewayEarning"><a
                            class="dropdown-item" href="#!">This Month</a><a class="dropdown-item"
                            href="#!">Previous Month</a><a class="dropdown-item" href="#!">Last
                            3 Months</a><a class="dropdown-item" href="#!">Last 6 Months</a></div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="card-body payment-gateway">
        <div class="pay-box">
            <div class="common-flex align-items-center">
                <div class="outer-line border-success">
                    <div class="outer-svg-box bg-light-success">
                        <svg class="fill-success">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#earning4') }}"></use>
                        </svg>
                    </div>
                </div>
                <p>Paid</p>
            </div>
            <span class="text-end txt-success">{{ number_format($totalpaid) }}</span>
        </div>

        <div class="pay-box">
            <div class="common-flex align-items-center">
                <div class="outer-line border-warning">
                    <div class="outer-svg-box bg-light-warning">
                        <svg class="fill-warning">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#earning4') }}"></use>
                        </svg>
                    </div>
                </div>
                <a class="f-w-500" href="#!">Unpaid</a>
            </div>
            <span class="text-end txt-warning">{{ number_format($totalunpaid) }}</span>
        </div>

        <div class="pay-box">
            <div class="common-flex align-items-center">
                <div class="outer-line border-info">
                    <div class="outer-svg-box bg-light-info">
                        <svg class="fill-info">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#earning4') }}"></use>
                        </svg>
                    </div>
                </div>
                <a class="f-w-500" href="#!">Pending</a>
            </div>
            <span class="text-end txt-info">{{ number_format($totalpending) }}</span>
        </div>

        <div class="pay-box">
            <div class="common-flex align-items-center">
                <div class="outer-line border-danger">
                    <div class="outer-svg-box bg-light-danger">
                        <svg class="fill-danger">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#earning4') }}"></use>
                        </svg>
                    </div>
                </div>
                <a class="f-w-500" href="#!">Cancel</a>
            </div>
            <span class="text-end txt-danger">{{ number_format($totalcancel) }}</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card widget-hover overflow-hidden">
            <div class="card-header card-no-border pb-2">
                <h5>Students</h5>
            </div>
            <div class="card-body pt-0 count-student">
                <div class="school-wrapper">
                    <div class="school-header">
                        <h4 class="txt-primary">{{ number_format($totalinvoice) }}</h4>
                        <div class="d-flex gap-1 align-items-center flex-wrap pt-xxl-0 pt-2">
                            <i class="icon-arrow-up f-light"></i><span
                                class="f-w-500 f-light">+6.7%</span>
                        </div>
                    </div>
                    <div class="school-body"> 
                        <img src="{{ asset('assets/images/dashboard-8/payment-option/cash.svg') }}" alt="total students">
                        <div class="right-line"><img
                                src="{{ asset('assets/images/dashboard-7/line.png') }}" alt="line">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>