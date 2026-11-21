@extends('layouts.member.master')

@section('title', 'Pesan Tiket')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>{{__('Pesan Tiket')}}</x-breadcrumb>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3" action="{{ route('app.invoice.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pesan Tiket</h4>
                        </div>
                        <div class="card-body">
                                @csrf
                                {{-- @method('PUT') --}}
                                @include('member.invoice.form')
                        </div>
                        <div class="card-footer text-end d-inline-flex gap-1 justify-content-end">
                            <x-form.buttonsimpan></x-form.buttonsimpan>
                            <x-form.buttonbatal href="{{ route('app.invoice.index')}}"></x-form.buttonbatal>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/print.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{ __('Pilih Membership') }}",
                allowClear: true
            });

            $('#durasi').change(function() {
                
                var durasi = $(this).val();
                var harga = 0;
                var membership = 'Personal';
                
                if (durasi == "{{ App\Helpers\AppHelper::getDurasiPersonal() }}") {
                    harga = "{{ App\Helpers\AppHelper::getHargaPersonal() }}";
                    membership = 'Personal';
                    $('#personal').show().stop(true, true).delay(200).slideDown(400);
                    $('#premium').hide();
                    $('#corporate').hide();
                } else if (durasi == "{{ App\Helpers\AppHelper::getDurasiPremium() }}") {
                    harga = "{{ App\Helpers\AppHelper::getHargaPremium() }}";
                    membership = 'Premium';
                    $('#personal').hide();
                    $('#premium').show().stop(true, true).delay(200).slideDown(400);
                    $('#corporate').hide();
                } else if (durasi == "{{ App\Helpers\AppHelper::getDurasiCorporate() }}") {
                    harga = "{{ App\Helpers\AppHelper::getHargaCorporate() }}";
                    membership = 'Corporate';
                    $('#personal').hide();
                    $('#premium').hide();
                    $('#corporate').show().stop(true, true).delay(200).slideDown(400);
                }
                $('#total').val(harga);
                $('#membership').val(membership);

            });
        });
    </script>
@endsection