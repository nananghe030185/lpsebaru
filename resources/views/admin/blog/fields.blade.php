<div class="row">
    <div class="col-lg-6">
        <x-form.text name="title" :required="true" :value="$blog->title ?? old('title')">Title</x-form.text>
        <x-form.text name="slug" :required="true" :value="$blog->slug ?? old('slug')">Slug</x-form.text>
        <x-form.texteditor name="content" :value="$blog->content ?? old('content')">Content</x-form.texteditor>
    </div>
    <div class="col-lg-6">
        <x-form.toggle name="status" :toggle="old('status', $blog ?? '')" :value="old('status', $blog->status ?? '')">Status</x-form.toggle>
        {{-- <x-form.image type="file" name="logo" :required="false" :value="old('logo', $lpse->logo ?? '')" :item="$lpse" routeremove="admin.lpse.removeImage">Logo</x-form.image> --}}

        <div class="mb-3 multi-images">
            <label for="">Images</label>
            <input class="form-control" type="file" name="images[]" multiple="multiple">
            @isset($blog)
                <div class="mt-2 row">
                    @foreach ($blog->getMedia('images') as $image)
                        <div class="col-xxl-1 col-md-2 col-sm-3 col-auto mb-2">
                            <div class="multi-remove position-relative">
                                <img src="{{ $image->getUrl() }}" alt="Image" class="img-thumbnail img-fix" width="100%">
                                <a href="{{ route('admin.blog.removeImage', $image->id) }}" 
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
                    @endforeach
                </div>
            @endisset
        </div>

        <div class="mb-3">
            <label for="">Thumbnail</label><span>*</span>
            <input class="form-control" type="file" name="thumbnail">
            @error('thumbnail')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @isset($blog)
                <div class="mt-3 comman-image">
                    @foreach ($blog->getMedia('thumbnail') as $image)
                        <img src="{{ $image->getUrl() }}" alt="Image" class="img-thumbnail img-fix" height="15%"
                            width="15%">
                    @endforeach
                </div>
            @endisset
        </div>

        <x-form.text name="meta_title" :required="true" :value="$blog->meta_title ?? old('meta_title')">Meta Title</x-form.text>

        <x-form.textarea name="meta_description" :value="$blog->meta_description ?? old('meta_description')">Meta Description</x-form.textarea>

        <div class="mb-3">
            <label class="form-label" for="">Meta Image</label>
            <input class="form-control" type="file" name="meta_image">
            @isset($blog)
                @php
                    $image = $blog->getFirstMedia('meta_image');
                @endphp
                <div class="mt-3 comman-image">
                    @if ($image)
                        <img src="{{ $image->getUrl() }}" alt="Image" class="img-thumbnail img-fix" height="30%"
                            width="30%">
                    @endif
                </div>
            @endisset
            @error('meta_image')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
