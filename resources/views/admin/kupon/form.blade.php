@php
    $now = \Carbon\Carbon::now();
@endphp
<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='kode' :value="old('kode', $kupon->kode ?? '')">Kode Kupon</x-form.text>
                <x-form.text name='diskon' type="number" :value="old('diskon', $kupon->diskon ?? '')">Diskon</x-form.text>
                <x-form.text name='stok' type="number" :value="old('stok', $kupon->stok ?? '')">Stok</x-form.text>
                <x-form.selectstatus :selected="$kupon->status ?? old('status')">Status</x-form.selectstatus>
            </div>
            <div class="col-lg-6">
                <x-form.calendar name="masa_berlaku" :value="isset($kupon->masa_berlaku) ? $kupon->masa_berlaku : old('masa_berlaku')" :required="true">{{__('Masa Berlaku')}}</x-form.calendar>
                <x-form.textarea name="keterangan" :value="old('keterangan', $kupon->keterangan ?? '')">Keterangan</x-form.textarea>
            </div>
        </div>
    </div>
</div>