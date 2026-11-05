@props(['name' => '', 'placeholder' => '', 'value' => '', 'readonly' => false, 'required' => false, 'autofocus' => false])

<div class="mb-3">
    <label class="form-label" for="human-friendly">{{ $slot }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}</label>
    <div class="input-group flatpicker-calender">
        <div class="input-group-text">
            <i class="icofont icofont-calendar" for="masa_berlaku"></i>
        </div>
        <input class="form-control" id="human-friendly" name="{{ $name }}" type="date" value="{{ $value }}" placeholder="Masa Berlaku" @readonly($readonly) @required($required)>
        @error('{{ $name }}')
            <div class="invalid-feedback"> 
                {{ $message }}
            </div>
        @enderror
    </div>
</div>