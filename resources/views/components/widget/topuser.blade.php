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