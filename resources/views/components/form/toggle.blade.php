<label class="form-label mb-1" style="display: block" for="{{ $name }}">{{ $slot }}</label>
<label class="switch">
    <input data-id="{{ $toggle->id }}"
        class="form-check-input toggle-status" type="checkbox" name="{{ $name }}"
        value="{{ $value }}" {{ $value ? 'checked' : '' }}>
    <span class="switch-state"></span>
</label>