<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='keyword' :required=true  :value="old('keyword', $autorespon->keyword ?? '')">Keyword</x-form.text>

                {{-- <div class="mt-3">
                    <label for="response">{{ __('Response') }}</label>
                    <div class="toolbar-box">
                        <div id="editor">{!! $autorespon->response ?? old('response') !!}</div>
                    </div>

                    <input type="hidden" name="response" value="{!! $autorespon->response ?? old('response') !!}" id="quill-editor-area">
                    @error('response')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div> --}}

               <x-form.editor name="response" :value="$autorespon->response ?? old('response')">Response</x-form.editor>

                <x-form.selectstatus name="whatsapp" :value="$autorespon->whatsapp ?? old('whatsapp')">WhatsApp</x-form.selectstatus>

                <x-form.selectstatus name="telegram" :value="$autorespon->telegram ?? old('telegram')">Telegram</x-form.selectstatus>
            </div>
            <div class="col-lg-6">
            </div>
        </div>
    </div>
</div>