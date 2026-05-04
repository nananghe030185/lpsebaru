@props(['jumlah' => 0, 'href' => '#', 'color' => 'success', 'icon' => asset('assets/svg/icon-sprite.svg#c-customer')])

<a href="{{ $href }}">
    <div class="card widget-1">
        <div class="card-body">
            <div class="widget-content">
                <div class="widget-round {{ $color }}">
                    <div class="bg-round"><svg>
                            <use href="{{ $icon }}"> </use>
                        </svg><svg class="half-circle svg-fill">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                        </svg></div>
                </div>
                <div>
                    <h4>
                        <span>{{ number_format($jumlah)}}</span>
                    </h4>
                    <span class="f-light">{{ $slot }}</span>
                </div>
            </div>
            <div class="font-success f-w-500"><i class="bookmark-search me-1"
                    data-feather="trending-up"></i><span class="txt-success">+70%</span>
            </div>
        </div>
    </div>
</a>