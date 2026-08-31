<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo_LPSE.png') }}" alt="">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_LPSE.png') }}" alt="">
            </a>
            <div class="back-btn">
                <i class="fa-solid fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('admin.dashboard') }}">
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
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
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
                        <label class="badge badge-light-primary">{{ App\Models\Invoice::count() }}</label>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.invoice.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-task') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-task') }}"></use>
                            </svg>
                            <span>{{ __('Invoice') }} </span>
                        </a>
                    </li>
                    
                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('Master Data') }}</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.lpse.index') }}">
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
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.satuan-kerja.index') }}">
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
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.klpdi.index') }}">
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
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.lelang-sirup.index') }}">
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
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.tender-lpse.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                            </svg>
                            <span>{{ __('Tender LPSE') }} </span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('Administrator') }}</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-blog') }}"></use>
                            </svg>
                            <span>{{ __('Blog') }} </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.category.index')}}">{{ __('Kategori') }}</a></li>
                            <li><a href="{{ route('admin.blog.index')}}">{{ __('Artikel') }}</a></li>
                            <li><a href="{{ route('admin.tag.index')}}">{{ __('Tag') }}</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                            </svg>
                            <span>{{ __('Broadcast') }} </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.broadcast.member')}}">{{ __('Member') }}</a></li>
                            <li><a href="{{ route('admin.broadcast.email')}}">{{ __('Email') }}</a></li>
                            <li><a href="{{ route('admin.broadcast.whatsapp')}}">{{ __('Whatsapp') }}</a></li>
                            <li><a href="{{ route('admin.broadcast.telegram')}}">{{ __('Telegram') }}</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg>
                            <span>{{ __('User') }} </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.user.group.index')}}">{{ __('User Group') }}</a></li>
                            {{-- <li><a href="{{ route('admin.user.profile')}}">{{ __('User Profile') }}</a></li> --}}
                            <li><a href="{{ route('admin.user.index')}}">{{ __('Users') }}</a></li>
                            <li><a href="{{ route('admin.role.index')}}">{{ __('Role') }}</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-icons') }}"></use>
                            </svg>
                            <span>{{ __('Pengaturan') }} </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.applikasi.index')}}">{{ __('Applikasi') }}</a></li>
                            <li><a href="{{ route('admin.whatsapp.index')}}">{{ __('Whatsapp') }}</a></li>
                            <li><a href="{{ route('admin.pengaturan.hapus-data')}}">{{ __('Hapus Data') }}</a></li>
                            <li><a href="{{ route('admin.auto-respon.index')}}">{{ __('Auto Respon') }}</a></li>
                            <li><a href="{{ route('admin.pengaturan.artisan')}}">{{ __('Artisan') }}</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-report') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-report') }}"></use>
                            </svg>
                            <span>{{ __('Laporan') }} </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.laporan.komisi.index')}}">{{ __('Komisi') }}</a></li>
                            <li><a href="{{ route('admin.laporan.keuangan')}}">{{ __('Keuangan') }}</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#inbox') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-inbox') }}"></use>
                            </svg>
                            <span>{{ __('InOut') }} </span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.inout.inbox.index')}}">{{ __('Inbox') }}</a></li>
                            <li><a href="{{ route('admin.inout.outbox.index')}}">{{ __('Outbox') }}</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.pengumuman.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>{{ __('Pengumuman') }} </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.errorlog.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-board') }}"></use>
                            </svg>
                            <span>{{ __('Error Log') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
