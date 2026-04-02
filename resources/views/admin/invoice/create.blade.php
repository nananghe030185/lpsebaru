@extends('layouts.admin.master')

@section('title', 'Pesan Tiket')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/tagify.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>{{__('Pesan Tiket')}}</x-breadcrumb>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3" action="{{ route('admin.invoice.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pesan Tiket</h4>
                        </div>
                        <div class="card-body">
                                @csrf
                                {{-- @method('PUT') --}}
                                @include('admin.invoice.form')
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" name="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            <a href="{{ route('admin.invoice.index')}}" class="btn btn-danger">{{ __('Batal')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

                if (durasi == "{{ App\Helpers\AppHelper::getDurasiPersonal() }}") {
                    harga = "{{ App\Helpers\AppHelper::getHargaPersonal() }}";
                } else if (durasi == "{{ App\Helpers\AppHelper::getDurasiPremium() }}") {
                    harga = "{{ App\Helpers\AppHelper::getHargaPremium() }}";
                } else if (durasi == "{{ App\Helpers\AppHelper::getDurasiCorporate() }}") {
                    harga = "{{ App\Helpers\AppHelper::getHargaCorporate() }}";
                }

                $('#total').val(harga);
            });
        });
    </script>
@endsection