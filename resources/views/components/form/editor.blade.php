<div class="mt-3">
	<label for="response">{{ __('Response') }}</label>
	<div class="toolbar-box">
		<div id="editor">{!! $autorespon->response ?? old('response') !!}</div>
	</div>

	<input type="hidden" name="response" value="{!! $autorespon->response ?? old('response') !!}" id="quill-editor-area">
	@error('response')
		<div class="text-danger mt-2">{{ $message }}</div>
	@enderror
</div>