@props(['name' => '', 'placeholder' => '', 'value' => '', 'readonly' => false, 'required' => false, 'type' => 'text', 'autofocus' => false])

<div class="mt-3">
    <label for="{{ $name }}">{{ $slot }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control" value="{{$value}}" placeholder="Masukan {{ $slot }}" @readonly($readonly) @required($required)>
    @error('{{ $name }}')
        <div class="invalid-feedback"> 
            {{ $message }}
        </div>
    @enderror
</div>