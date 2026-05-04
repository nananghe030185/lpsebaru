@props(['options' => [], 'selected' => null, 'name'=>'', 'required'=>false, 'error' => ''])

<div class="mb-3 col">
    <label class="form-label mb-1" for="{{ $name }}">{{$slot}}</label>
    <select name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'select2 form-select form-control']) }} {{ $required ? "required" : "" }}>
        <option value="" selected disabled>Pilih {{ $slot }}</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('{{ $name }}')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
