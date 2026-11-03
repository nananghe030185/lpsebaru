<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.select name="jenis_klpdi" :options="[
                        'KEMENTERIAN' => 'Kementerian',
                        'PROVINSI' => 'Provinsi',
                        'KOTA' => 'Kota',
                        'KABUPATEN' => 'Kabupaten',
                        'LEMBAGA' => 'Lembaga'
                    ]" :selected="old('jenis_klpdi', $klpdi->jenis_klpdi)" error="jenis_klpdi" >
                        Jenis KLPDI
                </x-form.select>

                <x-form.text name='nama_klpdi' :required=true  :value='old("nama_klpdi", $klpdi->nama_klpdi)'>Nama KLPDI</x-form.text>

                <x-form.text name='kode_kabupaten' type='number' :required=true  :value='old("kode_kabupaten", $klpdi->kode_kabupaten)'>Kode Kabupaten Kota</x-form.text>

            </div>
            <div class="col-lg-6">
                <x-form.text name='kode_klpdi' :required=true  :value='old("kode_klpdi", $klpdi->kode_klpdi)'>Kode KLPDI</x-form.text>

                <x-form.text name='kode_provinsi' type='number'  :required=true  :value='old("kode_provinsi", $klpdi->kode_provinsi)'>Kode Provinsi</x-form.text>

                <x-form.toggle name="scrape_daftar_hitam" :toggle="$klpdi" :value="old('scrape_daftar_hitam', $klpdi->scrape_daftar_hitam)">Scrape Daftar Hitam</x-form.toggle>
                 {{-- <x-form.selectstatus name="scrape_daftar_hitam" :selected="$klpdi->scrape_daftar_hitam">Scrape Daftar Hitam</x-form.selectstatus> --}}
            </div>
        </div>
    </div>
</div>