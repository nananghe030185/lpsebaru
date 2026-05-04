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