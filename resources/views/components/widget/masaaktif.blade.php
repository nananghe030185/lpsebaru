@props(['users' => [], 'masaberlaku' => 0, 'href' => '#'])

<div class="row">
    <div class="col-sm-12">
        <div class="card widget-hover overflow-hidden">
            <div class="card-header card-no-border pb-2">
                <h5>Masa Aktif Akun</h5>
            </div>
            <div class="card-body pt-0 count-student">
                <div class="school-wrapper">
                    <div class="school-header">
                        <h4 class="txt-primary">{{ $masaberlaku[0] }}</h4>
                        <div class="d-flex gap-1 align-items-center flex-wrap pt-xxl-0 pt-2">
                            <i class="fa fa-calendar f-light"></i>
                            <span class="f-w-500 f-light {{ $masaberlaku[1] > 0 ? 'text-success' : 'text-danger' }}">{{ $masaberlaku[1] }} Hari</span>
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