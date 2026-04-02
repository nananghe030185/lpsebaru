<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="kode_lpse">{{ __('Kode LPSE') }}</label>
                    <input type="number" name="kode_lpse" id="kode_lpse" class="form-control" value="{{ isset($lpse->kode_lpse) ? $lpse->kode_lpse : old('kode_lpse')}}" placeholder="Masukan Kode LPSE" readonly>
                </div>
                <div class="mt-3">
                    <label for="nama_lpse">{{ __('Nama LPSE') }}</label>
                    <input type="text" name="nama_lpse" id="nama_lpse" class="form-control" value="{{ isset($lpse->nama_lpse) ? $lpse->nama_lpse : old('nama_lpse')}}" placeholder="Masukan Nama LPSE" >
                </div>
                <div class="mt-3">
                    <label for="slug">{{ __('Slug') }}</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ isset($lpse->slug) ? $lpse->slug : old('slug')}}" placeholder="Masukan slug LPSE" >
                </div>
                <div class="mt-3">
                    <label for="link">{{ __('Link') }}</label>
                    <input type="text" name="link" id="link" class="form-control" value="{{ isset($lpse->link) ? $lpse->link : old('link')}}" placeholder="Masukan alamat link LPSE" >
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="jumlah_paket">{{ __('Jumlah Paket') }}</label>
                    <input type="number" name="jumlah_paket" id="jumlah_paket" class="form-control" value="{{ isset($lpse->jumlah_paket) ? $lpse->jumlah_paket : old('jumlah_paket')}}" placeholder="Masukan jumlah paketLPSE" >
                </div>
                <div class="mt-3">
                    <label for="jumlah_pagu">{{ __('Jumlah Pagu') }}</label>
                    <input type="number" name="jumlah_pagu" id="jumlah_pagu" class="form-control" value="{{ isset($lpse->jumlah_pagu) ? $lpse->jumlah_pagu : old('jumlah_pagu')}}" placeholder="Masukan Jumlah Pagu LPSE" >
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="state">{{ __('Status') }}</label>
                            <select name="state" id="state" class="select2 form-control">
                                <option value="1" @if ($lpse->state) selected @endif >{{ __('Active') }}</option>
                                <option value="0" @if (!$lpse->state) selected @endif >{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="scrape">{{ __('Scrape') }}</label>
                            <select name="scrape" id="scrape" class="select2 form-control">
                                <option value="1" @if ($lpse->scrape) selected @endif>{{ __('Active') }}</option>
                                <option value="0" @if (!$lpse->scrape) selected @endif>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="description">{{ __('Keterangan') }}</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ isset($lpse->description) ? $lpse->description : old('description')}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>