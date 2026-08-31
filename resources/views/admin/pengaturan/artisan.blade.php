@extends('layouts.admin.master')

@section('title', 'Artisan')

@section('css')
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Artisan</x-breadcrumb>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pengaturan.artisan.run') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="command" class="form-label">Command</label>
                    <input type="text" class="form-control" id="command" name="command" placeholder="route:list" required>
                </div>
                <button type="submit" class="btn btn-primary">Run Command</button>
            </form>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
@endsection

@section('scripts')
@endsection