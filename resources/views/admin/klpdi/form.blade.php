<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="jenis_klpdi">{{ __('Jenis KLPDI') }}</label>
                    <select name="jenis_klpdi" id="jenis_klpdi" class="form-control select2">
                        <option value="KEMENTERIAN" {{$klpdi->jenis_klpdi == "KEMENTERIAN" ? "selected":""}}>Kementerian</option>
                        <option value="KOTA" {{$klpdi->jenis_klpdi == "KOTA" ? "selected":""}}>Kota</option>
                        <option value="KABUPATEN" {{$klpdi->jenis_klpdi == "KABUPATEN" ? "selected":""}}>Kabupaten</option>
                        <option value="LEMBAGA" {{$klpdi->jenis_klpdi == "LEMBAGA" ? "selected":""}}>Lembaga</option>
                    </select>
                    
                    @error('jenis_klpdi')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="nama_klpdi">{{ __('Nama KLPDI') }}</label>
                    <input type="text" name="nama_klpdi" id="nama_klpdi" class="form-control" value="{{ old('nama_klpdi', $klpdi->nama_klpdi) }}" />
                    @error('nama_klpdi')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="kode_kabupaten">{{ __('Kode Kabupaten Kota') }}</label>
                    <input type="text" name="kode_kabupaten" id="kode_kabupaten" class="form-control" value="{{ old('kode_kabupaten', $klpdi->kode_kabupaten) }}" />
                    @error('kode_kabupaten')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="kode_klpdi">{{ __('Kode KLPDI') }}</label>
                    <input type="text" name="kode_klpdi" id="kode_klpdi" class="form-control" value="{{ old('kode_klpdi', $klpdi->kode_klpdi) }}" />
                    @error('kode_klpdi')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="kode_provinsi">{{ __('Kode Provinsi') }}</label>
                    <input type="text" name="kode_provinsi" id="kode_provinsi" class="form-control" value="{{ old('kode_provinsi', $klpdi->kode_provinsi) }}" />
                    @error('kode_provinsi')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="scrape_daftar_hitam">{{ __('Scrape Daftar Hitam') }}</label>
                    <select name="scrape_daftar_hitam" id="scrape_daftar_hitam" class="form-control select2">
                        <option value="true" {{$klpdi->scrape_daftar_hitam == "1" ? "selected":""}}>Active</option>
                        <option value="false" {{$klpdi->scrape_daftar_hitam == "0" ? "selected":""}}>Inactive</option>
                    </select>
                    
                    @error('scrape_daftar_hitam')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
            </div>
        </div>
    </div>
</div>