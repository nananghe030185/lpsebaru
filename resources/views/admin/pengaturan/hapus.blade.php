@extends('layouts.admin.master')

@section('title', 'Hapus Data')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Hapus Data</x-breadcrumb>

    <form action="{{ route('admin.pengaturan.hapus-data') }}" method="post" 
                    data-confirm-delete 
                    data-confirm-title="Apakah anda yakin ingin menghapus data ini ?"
                    data-confirm-text="Data yang dihapus tidak bisa di kembalikan"
                    data-confirm-button="Hapus"
                    data-confirm-cancel="Batal">
        @csrf
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 col-xxl-6">
                            <x-form.checkbox name="lelang">Lelang SIRUP</x-form.checkbox>
                            <x-form.checkbox name="tender">Tender LPSE</x-form.checkbox>
                            <x-form.checkbox name="inbox">Inbox</x-form.checkbox>
                            <x-form.checkbox name="outbox">Outbox</x-form.checkbox>
                            <x-form.checkbox name="notification_lelang">Notification Lelang</x-form.checkbox>
                            <x-form.checkbox name="notification_tender">Notification Tender</x-form.checkbox>
                        </div>
                        <div class="col-sm-12 col-lg-6 col-xxl-6">
                            <x-form.calendar name="before"  >{{__('Hapus sebelum')}}</x-form.calendar>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end d-inline-flex gap-1 justify-content-end">
                    <x-form.buttonsimpan>Hapus</x-form.buttonsimpan>
                </div>
            </div>
        </div>
    </form>
    

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
@endsection