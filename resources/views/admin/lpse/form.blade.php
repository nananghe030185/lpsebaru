<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name="kode_lpse" type="number" :required="true" :value="old('kode_lpse', $lpse->kode_lpse ?? '')">Kode LPSE</x-form.text>

                <x-form.text name="nama_lpse" :required="true" :value="old('nama_lpse', $lpse->nama_lpse ?? '')" :autofocus="true">Nama LPSE</x-form.text>
                
                <x-form.text name="slug" :required="true" :value="old('slug', $lpse->slug ?? '')">Slug</x-form.text>

                <x-form.text name="link" :required="true" :value="old('link', $lpse->link ?? '')">Link</x-form.text>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <x-form.toggle name="state" :toggle="old('state', $lpse ?? '')" :value="old('state', $lpse->state ?? '')">Status</x-form.toggle>
                        </div>
                        <div class="col-6">
                            <x-form.toggle name="scrape" :toggle="old('scrape', $lpse ?? '')" :value="old('scrape', $lpse->scrape ?? '')">Scrape</x-form.toggle>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <x-form.text type="number" name="jumlah_paket" :required="true" :value="old('jumlah_paket', $lpse->jumlah_paket ?? 0)">Jumlah Paket</x-form.text>

                <x-form.text type="number" name="jumlah_pagu" :required="true" :value="old('jumlah_pagu', $lpse->jumlah_pagu ?? 0)">Jumlah Pagu</x-form.text>

                <x-form.image type="file" name="logo" :required="false" :value="old('logo', $lpse->logo ?? '')">Logo</x-form.image>

                <x-form.textarea name="description" :value="old('description', $lpse->description ?? '')">Keterangan</x-form.textarea>
            </div>
        </div>
    </div>
</div>