<div class="card">
    <div class="card-header card-no-border">
        <div class="header-top">
            <h5>Grafik LPSE</h5>
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
                                        <h5 >{{ number_format($totalTender) }}</h5>
                                        <span class="f-light">Total Tender</span>
                                    </li>
                                    <li>
                                        <h5>{{ number_format($totalLelang) }}</h5>
                                        <span class="f-light">Total Lelang</span>
                                    </li>
                                </ul>
                                <div class="current-sale-container">
                                    <div id="grafik-lpse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>