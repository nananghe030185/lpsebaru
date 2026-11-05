@props(['username' => ''])
<div class="row">
    <div class="col-sm-12">
        <div class="card widget-hover overflow-hidden">
            <div class="card-header card-no-border pb-2">
                <h5>Link Referal</h5>
            </div>
            <div class="card-body pt-0 count-student">
                <div class="school-wrapper">
                    <div class="school-header">
                        <h4 class="txt-primary">{{ url('/') }}?r={{ $username }}</h4>
                        <div class="d-flex gap-1 align-items-center flex-wrap pt-xxl-0 pt-2">
                            <i class="icon-arrow-up f-light"></i><span
                                class="f-w-500 f-light">+6.7%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>