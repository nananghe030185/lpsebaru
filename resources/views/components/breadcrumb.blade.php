@props(['parent' => '', 'route' => '#', 'admin' => false])
<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ $slot }} </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ $admin ? route('admin.dashboard') : route('app.dashboard.index') }}"> 
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                            </a>
                        </li>
                        @if ($parent !== '')
                            <li class="breadcrumb-item">
                                <a href="{{ $route ?? url()->previous() }}">{{ $parent }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">{{ $slot }} </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>