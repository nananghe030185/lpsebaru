@props(['name' => 'status', 'selected'=> null])
<x-form.select name="{{ $name }}" :options="[
        true => 'Active',
        false => 'Inactive'
    ]" :selected="old($name, $selected)" error="{{ $name }}" >
        {{ $slot }}
</x-form.select>