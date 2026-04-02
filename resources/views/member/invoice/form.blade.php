<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-4">
                <div class="mt-3">
                    @php
                        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); 
                    @endphp
                    <label for="nomer">{{ __('Nomor Invoice') }}</label>
                    <input type="text" name="nomer" id="nomer" class="form-control" value="{{ $invoiceNumber }}" readonly>
                </div>
                {{-- <div class="mt-3">
                    <label for="total">{{ __('Member') }}</label>
                    <select name="user_id" id="user_id" class="form-control select2">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="mt-3">
                    <label for="durasi">{{ __('Membership') }}</label>
                    <select name="durasi" id="durasi" class="form-control select2">
                        <option value="{{ App\Helpers\AppHelper::getDurasiPersonal() }}">Personal - {{ App\Helpers\AppHelper::getDurasiPersonal() / 30 }} Bulan</option>
                        <option value="{{ App\Helpers\AppHelper::getDurasiPremium() }}">Premium - {{ App\Helpers\AppHelper::getDurasiPremium() /30 }} Bulan</option>
                        <option value="{{ App\Helpers\AppHelper::getDurasiCorporate() }}">Corporate - {{ App\Helpers\AppHelper::getDurasiCorporate() / 30 }} Bulan</option>
                    </select>
                    @error('durasi')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="total">{{ __('Harga') }}</label>
                    <input type="text" name="total" id="total" class="form-control" value="{{ App\Helpers\AppHelper::getHargaPersonal() }}" readonly >
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <a data-bs-toggle="collapse" data-bs-target="#personal">Personal</a>
                            </div>
                            <div class="card-body collapse" id="personal">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        Akses ke semua fitur dasar
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <a data-bs-toggle="collapse" data-bs-target="#premium">Premium</a>
                            </div>
                            <div class="card-body collapse" id="premium">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        Akses ke semua fitur dasar
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <a data-bs-toggle="collapse" data-bs-target="#corporate">Corporate</a>
                            </div>
                            <div class="card-body collapse" id="corporate">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        Akses ke semua fitur dasar
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>