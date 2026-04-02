@php
    $now = \Carbon\Carbon::now();
@endphp
<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="message">{{ __('Pesan') }}</label>
                    <input type="text" name="message" id="message" class="form-control" value="{{ isset($pengumuman->message) ? $pengumuman->message : old('message')}}" placeholder="Masukan Pesan anda disini" >
                    @error('message')
                        <div class="text-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="status">{{ __('Status') }}</label>
                    <select name="status" id="status" class="select2 form-control">
                        <option value="1" @if ($pengumuman->status) selected @endif >{{ __('Active') }}</option>
                        <option value="0" @if (!$pengumuman->status) selected @endif >{{ __('Inactive') }}</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="example-datetime-local-input">{{ __('Kadaluarsa') }}</label>
                    <input type="datetime-local" name="expire" id="example-datetime-local-input" class="form-control digits" value="{{ isset($pengumuman->expire) ? $pengumuman->expire : $now }}" placeholder="Tentukan Kadaluarsa Pesan" >
                </div>
            </div>
        </div>
    </div>
</div>