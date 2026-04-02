{{-- resources/views/admin/whatsapp/send.blade.php --}}
@extends('layouts.admin.master')
@section('title', 'Send WhatsApp Message')
@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Whatsapp</x-breadcrumb>

    <div class="containe-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Kirim Pesan Whatsapp via session ID : {{ $sessionId }}</h5>
            </div>
            <div class="card-body">
                <div class="card-text">
                    @if(session('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.whatsapp.send', $sessionId) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="token" value="{{ $sessionId }}">
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Nomer Whatsapp Penerima (dengan kode negara)</label>
                            <input type="text" class="form-control" id="number" name="number" placeholder="e.g., 62812345678" value="{{old('number')}}" required>
                            @error('number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Ketik Pesan anda disini ..." required>{{old('message')}}</textarea>
                            @error('message')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                        <a href="{{ route('admin.whatsapp.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
@endsection