@extends('layouts.admin.master')

@section('title', 'Edit Group User')

@section('css')
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb parent="Group User" route="{{ route('admin.user.group.index') }}">Edit</x-breadcrumb>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Group User</h5>
                    </div>
                    <form class="form theme-form" action="{{ route('admin.user.group.update', $group->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama Group User <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Masukkan Nama Group" value="{{ old('name', $group->name) }}"
                                                required>
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description" rows="3"
                                                placeholder="Masukkan Description">{{ old('description', $group->description) }}</textarea>
                                                @error('description')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('admin.user.group.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection