@extends('layouts.admin.master')

@section('title', 'Edit WhatsApp Session')

@section('css')
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Whatsapp</x-breadcrumb>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit WhatsApp Session</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.whatsapp.update', $whatsapp->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Masukkan Name" value="{{ old('name', $whatsapp->name) }}"
                                                required>
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Number <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="number"
                                                placeholder="Masukkan Number"
                                                value="{{ old('number', $whatsapp->number) }}" required readonly>
                                                @error('number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description" rows="3"
                                                placeholder="Masukkan Description">{{ old('description', $whatsapp->description) }}</textarea>
                                                @error('description')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <x-form.buttonsimpan></x-form.buttonsimpan>
                            <x-form.buttonbatal href="{{ route('admin.whatsapp.index')}}"></x-form.buttonbatal>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection