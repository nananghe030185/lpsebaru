{{-- @props(['items' => []]) --}}
<div class="card">
    <div class="card-header card-no-border">
        <div class="header-top">
            <h5>Histori Aplikasi</h5>
            <div class="card-header-right-icon">
                <div class="dropdown icon-dropdown">
                    <button class="btn dropdown-toggle" id="manageButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="icon-more-alt"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="manageButton">
                        <a class="dropdown-item" href="{{ route('admin.errorlog.index') }}">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-0 h-20 position-relative overflow-scroll" style="max-height: 440px">
        <ul class="appointments-wrapper">
            @foreach ($items as $item)
                <li class="d-flex align-items-start"><span>{{ Carbon\Carbon::parse($item->created_at)->format('H:i') }}</span>
                    <div class="bg-lighter-primary"></div>
                    <div class="main-box">
                        <div class="mb-2"> 
                            <span>{{ Illuminate\Support\Str::limit($item->message,150) }}</span>
                            <br>
                            <small class="c-o-light ">
                                {{ Illuminate\Support\Str::limit($item->trace,50) }}
                            </small>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>