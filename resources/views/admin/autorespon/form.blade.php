<div class="container-fluid">
    <div class="form theme-form custom-input">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='keyword' :required=true  :value="old('keyword', $autorespon->keyword ?? '')">Keyword</x-form.text>

                <x-form.textarea name="response" :value="$autorespon->response ?? old('response')" :required=true >Response</x-form.textarea>
            </div>
            <div class="col-lg-6">
                <x-form.toggle name="status" :toggle="old('status', $lpse ?? '')" :value="old('status', $autorespon->status ?? '')">Status</x-form.toggle>

                <x-form.toggle name="whatsapp" :toggle="old('whatsapp', $lpse ?? '')" :value="old('whatsapp', $autorespon->whatsapp ?? '')">Whatsapp</x-form.toggle>

                <x-form.toggle name="telegram" :toggle="old('telegram', $lpse ?? '')" :value="old('telegram', $autorespon->telegram ?? '')">Telegram</x-form.toggle>
            </div>
        </div>
    </div>
</div>