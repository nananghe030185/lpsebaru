<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-12">
                <x-form.text name='nama_paket' :required=true  :value='old("nama_paket", $tender_lpse->nama_paket)'>Nama Paket</x-form.text>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='tender_id' :required=true  :value='old("tender_id", $tender_lpse->tender_id)' :readonly=true>Kode Tender</x-form.text>

                <x-form.text name='nama_lpse' :required=true  :value='old("nama_lpse", $tender_lpse->nama_lpse)' :readonly=true>Nama LPSE</x-form.text>

                <x-form.text name='tahap_tender' :required=true  :value='old("tahap_tender", $tender_lpse->tahap_tender)' :readonly=true>Tahap Tender</x-form.text>

                <x-form.text name='kategori' :required=true  :value='old("kategori", $tender_lpse->kategori)' :readonly=true>Kategori</x-form.text>

                <x-form.text name='nilai_kontrak' :required=true  :value='old("nilai_kontrak", $tender_lpse->nilai_kontrak)' :readonly=true>Nilai Kontrak</x-form.text>
            </div>
            <div class="col-lg-6">
                <x-form.text name='metode_pemilihan' :required=true  :value='old("metode_pemilihan", $tender_lpse->metode_pemilihan)' :readonly=true>Metode Pemilihan</x-form.text>

                <x-form.text name='metode_pengadaan' :required=true  :value='old("metode_pengadaan", $tender_lpse->metode_pengadaan)' :readonly=true>Metode Pengadaan</x-form.text>

                <x-form.text name='hps' :required=true  :value='old("hps", $tender_lpse->hps)' :readonly=true>HPS</x-form.text>

                <x-form.textarea name='description' :value='old("description", $tender_lpse->description)'>Description</x-form.textarea>
            </div>
        </div>
    </div>
</div>