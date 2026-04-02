@extends('layouts.admin.master')

@section('title', 'Checkout')

@section('css')
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>{{__('Checkout')}}</x-breadcrumb>

    <div class="container-fluid">
        <div class="row">
             {{-- Layanan --}}
            <div class="col-sm-6">
                 {{-- <form class="row g-3" action="{{ route('admin.invoice.store') }}" method="POST" enctype="multipart/form-data"> --}}
                    <div class="card pricing-simple">
                        <div class="card-header">
                            <h4>{{__('Layanan')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="pricingtable">
                                    <div class="pricingtable-header">
                                        <h3 class="title">Personal</h3>
                                    </div>
                                    <h5 class="mb-2">
                                        <span class="currency">Rp. </span>
                                        <span class="amount">{{ number_format($invoice->total, 0, ',', '.') }}</span>
                                    </h5>
                                    <ul class="pricing-content">
                                        <li>Email Notifikasi</li>
                                        <li>Telegram Notifikasi</li>
                                        <li>Whatsapp Notifikasi</li>
                                        <li>Member Area</li>
                                        <li>Akses Semua LPSE</li>
                                        <li>Download Data Tender</li>
                                        <li>Download Data Lelang</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </form> --}}
            </div>

            {{-- Pesanan Anda --}}
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('Pesanan Anda')}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ __('Nomor Invoice') }}</th>
                                <td>{{ $invoice->nomer }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Member') }}</th>
                                <td>{{ $invoice->user->name }} - {{ $invoice->user->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Membership') }}</th>
                                <td>{{ $invoice->durasi / 30 }} Bulan</td>
                            </tr>
                            <tr>
                                <th>{{ __('Harga') }}</th>
                                <td>Rp. {{ number_format($invoice->total, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        <button id="pay" name="submit" class="btn btn-primary">{{ __('Bayar') }}</button>
                        <a href="{{ route('admin.invoice.index')}}" class="btn btn-danger">{{ __('Batal')}}</a>
                    </div>
                </div>
            </div>

           {{-- <div id="result-json"></div> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $client_key }}"></script>
    <script type="text/javascript">
        document.getElementById('pay').onclick = function(){
            // SnapToken acquired from previous step
            snap.pay('{{ $invoice->snap_token }}', {
                // Optional
                onSuccess: function(result){

                    /* You may add your own js here, this is just example */ 
                     document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                
                    const baseurl = window.location.origin;
                    fetch(baseurl + '/api/invoice/checkout', {
                        method : 'POST',
                        headers : {
                            'Content-Type' : 'application/json'
                        },
                        body : JSON.stringify(result)
                    })
                    .then(response => response.json())
                    .then(result => console.log('success : ', result))
                    .catch(error => console.log('Error : ', error));
                },
                // Optional
                onPending: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                
                    const baseurl = window.location.origin;
                    fetch(baseurl + '/api/invoice/checkout', {
                        method : 'POST',
                        headers : {
                            'Content-Type' : 'application/json'
                        },
                        body : JSON.stringify(result)
                    })
                    .then(response => response.json())
                    .then(result => console.log('success : ', result))
                    .catch(error => console.log('Error : ', error));
                },
                // Optional
                onError: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onClose: function(){
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        };
    </script>
@endsection


