<div class="product-upload">
    <p>Image Profile</p>
    <form class="dropzone dropzone-secondary" id="singleFileUpload"
        action="{{ route('admin.user.update-image', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="dropzone-wrapper">
            <div class="dz-message needsclick"><i
                    class="fa-solid fa-cloud-arrow-up fa-fade"></i>
                <h6>Gusur file ke sini atau klik untuk upload</h6>
                <span class="note needsclick">SVG,PNG,JPG
                    <strong>or</strong> GIF</span>
            </div>
        </div>
        <div class="fallback">
            <input name="image" type="file" multiple />     
        </div>
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>
</div>
