<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='nomer' :readonly=true  :value="'INV-' . date('Ymd') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT)">Nomor Invoice</x-form.text>

                <div class="mt-3">
                    <label for="total">{{ __('Member') }}</label>
                    <select name="user_id" id="user_id" class="form-control select2">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>

                <x-form.select name="durasi" :options="[
                        App\Helpers\AppHelper::getDurasiPersonal() => 'Personal - ' .  App\Helpers\AppHelper::getDurasiPersonal() / 30 . '  Bulan',
                        App\Helpers\AppHelper::getDurasiPremium() => 'Premium - '. App\Helpers\AppHelper::getDurasiPremium() / 30 .' Bulan',
                        App\Helpers\AppHelper::getDurasiCorporate() => 'Corporate - '. App\Helpers\AppHelper::getDurasiCorporate() / 30 .' Bulan'
                    ]" :selected='App\Helpers\AppHelper::getDurasiPersonal()'>
                        Membership
                </x-form.select>

                <x-form.text name='total' :readonly=true  :value="App\Helpers\AppHelper::getHargaPersonal()">Harga</x-form.text>

                
            </div>
            <div class="col-lg-6">
            </div>
        </div>
    </div>
</div>