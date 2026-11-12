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
                                    <x-form.text name="name" type="text" :required="true" :value="old('name', $group->name ?? '')">Nama Group User</x-form.text>

                                    <x-form.textarea name="description" :value="old('description', $group->description ?? '')">Description</x-form.textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end d-inline-flex gap-1 justify-content-end">
                            <x-form.buttonsimpan></x-form.buttonsimpan>
                            <x-form.buttonbatal href="{{ route('admin.user.group.index')}}"></x-form.buttonbatal>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection