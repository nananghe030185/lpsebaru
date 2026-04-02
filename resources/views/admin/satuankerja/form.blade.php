<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="kode_satker">{{ __('Kode Satker') }}</label>
                    <input type="number" name="kode_satker" id="kode_satker" class="form-control" value="{{ isset($satker->kode_satker) ? $satker->kode_satker : old('kode_satker')}}" placeholder="Masukan Kode Satker" readonly>
                </div>
                <div class="mt-3">
                    <label for="kode_klpd">{{ __('Kode KLPDI') }}</label>
                    <input type="text" name="kode_klpd" id="kode_klpd" class="form-control" value="{{ isset($satker->kode_klpd) ? $satker->kode_klpd : old('kode_klpd')}}" placeholder="Masukan Kode KLPDI" readonly>
                </div>
                <div class="mt-3">
                    <label for="nama_satker">{{ __('Nama Satuan Kerja') }}</label>
                    <input type="text" name="nama_satker" id="nama_satker" class="form-control" value="{{ isset($satker->nama_satker) ? $satker->nama_satker : old('nama_satker')}}" placeholder="Masukan Nama Satuan Kerja" >
                </div>
            </div>
        </div>
    </div>
</div>