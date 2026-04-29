@props(['name' => null, 'value' => null, 'required' => false])

<div class="mt-3">
    <label for="{{ $name }}">{{ $slot }} @if ($required) <span class="text-danger">*</span> @endif</label>
    <textarea name="{{ $name }}" id="{{ $name }}" cols="30" rows="5" class="form-control">{{ old($name, $value) }}</textarea>
</div>