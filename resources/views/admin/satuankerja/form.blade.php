<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                
                <x-form.text name='kode_satker' :readonly=true  :value='old("kode_satker", $satker->kode_satker)'>Kode Satker</x-form.text>

                <x-form.text name='kode_klpd' :readonly=true  :value='old("kode_klpd", $satker->kode_klpd)'>Kode KLPDI</x-form.text>

                <x-form.text name='nama_satker' :required=true  :value='old("nama_satker", $satker->nama_satker)'>Nama Satuan Kerja</x-form.text>

                <x-form.toggle name="lelang" :toggle="$satker" :value="old('lelang', $satker->lelang)">Lelang</x-form.toggle>

                
                <x-form.toggle name="swakelola" :toggle="$satker" :value="old('swakelola', $satker->swakelola)">Swakelola</x-form.toggle>
            </div>
        </div>
    </div>
</div>