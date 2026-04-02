@extends('layouts.member.master')

@section('title', 'Invoice')

@section('css')
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>{{__('Invoice')}}</x-breadcrumb>
    
    <!-- Container-fluid starts-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice">
                            <div>
                                <div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="d-flex">
                                                <div class="media-left"><img class="media-object img-60 for-light"
                                                        src="{{ asset('assets/images/other-images/logo-login.png') }}"
                                                        alt=""><img class="media-object img-60 for-dark"
                                                        src="{{ asset('assets/images/other-images/logo-light.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="flex-grow-1 m-l-20 text-right">
                                                    <h4 class="media-heading">LPSE Indonesia</h4>
                                                    {{-- <p>hello@cuba.in<br><span>289-335-6503</span></p> --}}
                                                </div>
                                            </div><!-- End Info-->
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-md-end text-xs-center">
                                                <h3>Invoice #{{$invoice->nomer}}</h3>
                                                <p>Issued: {{$invoice->tanggal_terbit}}<br> 
                                                    Payment Due: {{$invoice->tanggal_bayar}}
                                                </p>
                                            </div><!-- End Title-->
                                        </div>
                                    </div>
                                </div>
                                <hr><!-- End InvoiceTop-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="media-left"><img class="media-object rounded-circle img-60"
                                                    src="{{ asset('assets/images/user/1.jpg') }}" alt=""></div>
                                            <div class="flex-grow-1 m-l-20">
                                                <h4 class="media-heading">{{$invoice->user->name}}</h4>
                                                <p>{{$invoice->user->email}}<br><span>{{$invoice->user->perusahaan}}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-8">
                                        
                                    </div> --}}
                                </div><!-- End Invoice Mid-->
                                <div>
                                    <div class="table-responsive invoice-table custom-scrollbar" id="table">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="item">
                                                        <h6 class="p-2 mb-0">Item Description</h6>
                                                    </td>
                                                    <td class="subtotal">
                                                        <h6 class="p-2 mb-0">Status</h6>
                                                    </td>
                                                    <td class="Hours">
                                                        <h6 class="p-2 mb-0">Durasi (Bulan)</h6>
                                                    </td>
                                                    <td class="subtotal">
                                                        <h6 class="p-2 mb-0">Sub-total</h6>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="itemtext">{{$invoice->keterangan}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0">
                                                            @if($invoice->status == 'paid')
                                                                <span class="badge badge-success">Paid</span>
                                                            @elseif($invoice->status == 'unpaid')
                                                                <span class="badge badge-danger">Unpaid</span>
                                                            @else
                                                                <span class="badge badge-warning">Pending</span>
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0">{{$invoice->durasi / 30}}</p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0">Rp. {{number_format($invoice->total)}}</p>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    {{-- <td></td> --}}

                                                    <td class="Rate">
                                                        <h6 class="mb-0 p-2">Total</h6>
                                                    </td>
                                                    <td class="payment">
                                                        <h6 class="mb-0 p-2">Rp. {{number_format($invoice->total)}}</h6>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div><!-- End Table-->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div>
                                                @if ($invoice->status == 'paid')
                                                    <p class="legal text-success"><strong>Paid on:</strong> {{$invoice->tanggal_bayar}}</p>
                                                @elseif ($invoice->status == 'unpaid')
                                                    <p class="legal text-danger"><strong>Unpaid : </strong>
                                                    {{ Illuminate\Support\Str::replace('{nominal}', number_format($invoice->total) ,App\Helpers\AppHelper::getMessageNotifikasiTiket()) }}  </p>
                                                @else
                                                    <p class="legal text-warning"><strong>Pending</strong></p>
                                                    
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{-- <form class="text-md-end text-center">
                                                <input type="image"
                                                    src="{{ asset('assets/images/other-images/paypal.png') }}"
                                                    name="submit" alt="PayPal - The safer, easier way to pay online!">
                                            </form> --}}
                                        </div>
                                    </div>
                                </div><!-- End InvoiceBot-->
                            </div>
                            <div class="col-sm-12 text-center mt-3 print-btn">
                                <button class="btn btn btn-primary me-2"
                                    type="button" onclick="myFunction()">{{__('Print')}}</button>

                                <a href="{{route('app.invoice.index')}}" class="btn btn-danger">{{__('Tutup')}}</a>
                            </div>
                            <!-- End Invoice--><!-- End Invoice Holder--><!-- Container-fluid Ends-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/print.js') }}"></script>
@endsection
