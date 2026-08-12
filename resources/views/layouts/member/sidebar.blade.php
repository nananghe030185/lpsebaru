<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('app.dashboard.index') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="">
            </a>
            <div class="back-btn">
                <i class="fa-solid fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('app.dashboard.index') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa-solid fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>{{ __('Pinned') }}</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('General') }}</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.dashboard.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <label class="badge badge-light-primary">{{ App\Models\Invoice::where('user_id', Illuminate\Support\Facades\Auth::user()->id)->count() }}</label>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.invoice.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-task') }}"></use>
                            </svg>
                            <span>{{ __('Invoice') }} </span>
                        </a>
                    </li>
                    
                    @can('member')
                        <li class="sidebar-main-title">
                            <div>
                                <h6>{{ __('Master Data') }}</h6>
                            </div>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav active" href="{{ route('app.lpse.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                </svg>
                                <span>{{ __('LPSE') }} </span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.satuan-kerja.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                </svg>
                                <span>{{ __('Satuan Kerja') }} </span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.klpdi.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                                </svg>
                                <span>{{ __('KLPDI') }} </span>
                            </a>
                        </li>

                        <li class="sidebar-main-title">
                            <div>
                                <h6>{{ __('Paket') }}</h6>
                            </div>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.lelang-sirup.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                                </svg>
                                <span>{{ __('Lelang SIRUP') }} </span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <label class="badge badge-light-primary">{{ App\Models\FokusLelang::where('user_id', Illuminate\Support\Facades\Auth::user()->id)->count() }}</label>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.fokus-lelang.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}"></use>
                                </svg>
                                <span>{{ __('Fokus Lelang') }} </span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.tender-lpse.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                                </svg>
                                <span>{{ __('Tender LPSE') }} </span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <label class="badge badge-light-primary">{{ App\Models\Fokus::where('fokus',false)->where('user_id', Illuminate\Support\Facades\Auth::user()->id)->count() }}</label>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.tender-kata-kunci.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <span>{{ __('Tender Kata Kunci') }} </span>
                            </a>
                        </li>
                        
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <label class="badge badge-light-primary">{{ App\Models\Fokus::where('fokus',true)->where('user_id', Illuminate\Support\Facades\Auth::user()->id)->count() }}</label>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('app.fokus-paket.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#star') }}"></use>
                                </svg>
                                <span>{{ __('Fokus Tender') }} </span>
                            </a>
                        </li>

                    @endcan
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
