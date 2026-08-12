<div class="mt-3">
	<label for="response">{{ __('Response') }}</label>
	<div class="toolbar-box">
		<div id="editor">{{ $value }}</div>
	</div>

	<input type="hidden" name="response" value="{{ $value }}" id="quill-editor-area">
	@error('response')
		<div class="text-danger mt-2">{{ $message }}</div>
	@enderror
</div>