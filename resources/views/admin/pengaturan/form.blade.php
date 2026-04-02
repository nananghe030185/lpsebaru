<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="id">{{ __('ID') }}</label>
                    <input type="number" name="id" id="id" class="form-control" value="{{ isset($pengaturan->id) ? $pengaturan->id : old('id')}}" readonly>
                </div>
                <div class="mt-3">
                    <label for="key">{{ __('Kata Kunci') }}</label>
                    <input type="text" name="key" id="key" class="form-control" value="{{ isset($pengaturan->key) ? $pengaturan->key : old('key')}}" readonly>
                </div>
                <div class="mt-3">
                    <label for="description">{{ __('Keterangan') }}</label>
                    <input type="text" name="description" id="description" class="form-control" value="{{ isset($pengaturan->description) ? $pengaturan->description : old('description')}}" readonly>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="value">{{ __('Value') }}</label>
                    <input type="text" name="value" id="value" class="form-control" value="{{ isset($pengaturan->value) ? $pengaturan->value : old('value')}}" placeholder="Masukan value" >
                </div>
                {{-- <div class="mt-3">
                    <label for="order">{{ __('No Urut') }}</label>
                    <input type="text" name="order" id="order" class="form-control" order="{{ isset($pengaturan->order) ? $pengaturan->order : old('order')}}" placeholder="Masukan Nomer Urut" >
                </div> --}}
            </div>
        </div>
    </div>
</div>