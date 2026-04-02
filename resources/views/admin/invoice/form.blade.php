<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    @php
                        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); 
                    @endphp
                    <label for="nomer">{{ __('Nomor Invoice') }}</label>
                    <input type="text" name="nomer" id="nomer" class="form-control" value="{{ $invoiceNumber }}" readonly>
                </div>
                <div class="mt-3">
                    <label for="total">{{ __('Member') }}</label>
                    <select name="user_id" id="user_id" class="form-control select2">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
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
            <div class="col-lg-6">
            </div>
        </div>
    </div>
</div>