@props(['name' => '', 'placeholder' => '', 'value' => '', 'readonly' => false, 'required' => false, 'readonly' => false, 'autofocus' => false, 'icon' => 'icofont icofont-building'])

<div class="mb-3">
    <label class="form-label" for="{{ $name }}">{{ $slot }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}</label>
    <div class="input-group">
        <div class="input-group-text">
            <i class="{{ $icon }}" for="{{ $name }}"></i>
        </div>
        <input class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" type="text" placeholder="{{ $name }}" value="{{ $value }}" @readonly($readonly) @required($required)>
    </div>
    @error($name)
        <small class="text-danger">
            <strong>{{ $message }}</strong>
        </small>
    @enderror
</div>