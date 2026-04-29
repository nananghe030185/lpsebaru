<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='id' type="number" :readonly=true  :value='old("id", $pengaturan->id)'>ID</x-form.text>

                <x-form.text name='key' :readonly=true  :value='old("key", $pengaturan->key)'>Keterangan</x-form.text>
              
                <x-form.text name='description' :readonly=true  :value='old("description", $pengaturan->description)'>Keterangan</x-form.text>
            </div>
            <div class="col-lg-6">
                <x-form.text name='value' :required=true  :value='old("value", $pengaturan->value)'>Value</x-form.text>
            </div>
        </div>
    </div>
</div>