@props(['name' => '', 'value' => '', 'autofocus' => false])

<div class="mt-3">
    <div class="form-check checkbox checkbox-primary mb-0">
        <input class="form-check-input" id="{{ $name }}" type="checkbox" checked="" name="{{ $name }}">
        <label class="form-check-label" for="{{ $name }}">{{ $slot }}</label>
    </div>
</div>