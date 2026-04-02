<div class="notification-slider">
    @php
        $infos = App\Models\Pengumuman::where('status', true)->where('expire', '>', Carbon\Carbon::now())->get();
    @endphp
    @foreach ($infos as $info)
        <div class="d-flex h-100"> 
            <i class="icofont icofont-mega-phone m-1"></i>
                <h6 class="mb-0 f-w-400 pl-5 ml-10 rounded ">
                    {{-- <span class="font-primary">{{ $info->message}}</span> --}}
                    <span class="f-light">{{ $info->message}}</span>
                </h6>
        </div>
    @endforeach
   
</div>