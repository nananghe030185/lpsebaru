@props(['name' => '', 'placeholder' => '', 'value' => '', 'readonly' => false, 'required' => false, 'type' => 'file', 'autofocus' => false, 'item' =>'', 'routeremove' => ''])

<div class="mt-3 multi-images">
    <label for="{{ $name }}">{{ $slot }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control" value="{{$value}}" placeholder="Masukan {{ $slot }}" @readonly($readonly) @required($required)>
    @isset($item)
        @php
            $image = $item->getFirstMedia($name);
        @endphp
        <div class="mt-3 comman-image">
            @if ($image)
                <div class="col-xxl-1 col-md-2 col-sm-3 col-auto mb-2">
                    <div class="multi-remove position-relative">
                        <img src="{{ $image->getUrl() }}" alt="Image" class="img-thumbnail img-fix" width="100%">
                        <a href="{{ route($routeremove, $image->id) }}" 
                            data-confirm-delete
                            data-confirm-method="get"
                            data-confirm-title="Apakah anda yakin ingin menghapus data ini ?"
                            data-confirm-text="Data yang dihapus tidak bisa di kembalikan"
                            data-confirm-button="Hapus"
                            data-confirm-cancel="Batal">
                            <i data-feather="trash-2" class="remove-icon delete-confirmation text-danger" ></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endisset
    @error('{{ $name }}')
        <div class="invalid-feedback"> 
            {{ $message }}
        </div>
    @enderror
</div>