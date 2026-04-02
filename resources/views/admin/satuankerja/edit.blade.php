@extends('layouts.admin.master')

@section('title', 'Edit Satuan Kerja')

@section('css')
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Satuan Kerja</x-breadcrumb>

    {{-- Form --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                 <form class="row g-3 custom-input" id="userForm" action="{{ route('admin.satuan-kerja.update', $satker->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Satuan Kerja</h4>
                        </div>
                        <div class="card-body">
                                @csrf
                                @method('PUT')

                                @include('admin.satuankerja.form')
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" name="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            <a href="{{ route('admin.satuan-kerja.index')}}" class="btn btn-danger">{{ __('Batal')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection