@extends('layouts.admin.master')

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
                                                <p>Issued: {{Carbon\Carbon::parse($invoice->tanggal_terbit)->setTimezone('Asia/Jakarta')->format('d M Y H:i:s')}}<br> 
                                                    Payment Due: @if ($invoice->tanggal_bayar)
                                                        {{Carbon\Carbon::parse($invoice->tanggal_bayar)->setTimezone('Asia/Jakarta')->format('d M Y H:i:s')}}
                                                    @else
                                                        Belum Dibayar
                                                    @endif
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
                                                        <p class="itemtext">{{$invoice->item}}</p>
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
                                                    <p class="legal text-success"><strong>Paid on:</strong> {{ Carbon\Carbon::parse($invoice->tanggal_bayar)->format('d M Y H:i:s')}}</p>
                                                @elseif ($invoice->status == 'unpaid')
                                                        Silahkan lakukan pembayaran dengan mengklik link disini:
                                                        <a href="{{ route('admin.invoice.pay', $invoice->nomer) }}">Bayar Sekarang</a>
                                                @elseif ($invoice->status == 'failed')
                                                    {{ $invoice->keterangan }}
                                                @else
                                                    {{ $invoice->keterangan . ' sebelum tanggal ' . Carbon\Carbon::parse($invoice->tanggal_terbit)->addDay()->format('d M Y H:i:s') }}
                                                    <br>
                                                    <strong>Note:</strong> Jika tidak melakukan pembayaran sebelum tanggal tersebut, invoice ini akan dianggap kadaluarsa.
                                                    <br>
                                                    Klik <a href="{{$invoice->pdf_url}}" target="_blank">Panduan Pembayaran</a>
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

                                <a href="{{route('admin.invoice.index')}}" class="btn btn-danger">{{__('Tutup')}}</a>
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
