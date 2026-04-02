<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="mt-3">
                    <label for="keyword">{{ __('Keyword') }}</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" value="{{ $autorespon->keyword ?? old('keyword')}}" required>
                    @error('keyword')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="response">{{ __('Response') }}</label>
                    <div class="toolbar-box">
                        <div id="toolbar8"><span class="ql-formats">
                                <select class="ql-size">
                                    <option value="small">Small</option>
                                    <option selected="">Normal</option>
                                    <option value="large">Large</option>
                                    <option value="huge">Huge</option>
                                </select></span><span class="ql-formats">
                                <button class="ql-bold">Bold</button>
                                <button class="ql-italic">Italic</button>
                                <button class="ql-underline">Underline</button>
                                <button class="ql-strike">Strike</button>
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button></span><span
                                class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button></span><span
                                class="ql-formats">
                                <button class="ql-list" value="ordered">List</button>
                                <button class="ql-list" value="bullet">Bullet</button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button></span><span
                                class="ql-formats">
                                <button class="ql-link">Link</button>
                                <button class="ql-image">Image</button>
                                <button class="ql-video">Video</button>
                                <select class="ql-color"></select>
                                <select class="ql-background"></select></span>
                            <!-- Add more options here--><span class="ql-formats">
                                <button class="ql-blockquote">Blockquote</button>
                                <button class="ql-code-block"></button></span><span
                                class="ql-formats">
                                <button class="ql-align" value=""></button>
                                <button class="ql-align" value="center"></button>
                                <button class="ql-align" value="right"></button>
                                <button class="ql-align" value="justify"></button></span><span
                                class="ql-formats">
                                <button class="ql-clean"></button></span>
                        </div>
                    <div id="editor8">{!! $autorespon->response ?? old('response') !!}</div>
                </div>
                <input type="hidden" name="response" value="{!! $autorespon->response ?? old('response') !!}" id="quill-editor-area">
                @error('response')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                </div>
                <div class="mt-3">
                    <label for="whatsapp">{{ __('Whatsapp') }}</label>
                    <select name="whatsapp" id="whatsapp" class="form-control autorespon-channel">
                        <option value="true" {{ ($autorespon->whatsapp?? '') == '1' ? 'selected' : '' }}>{{__('Active')}}</option>
                        <option value="false" {{ ($autorespon->whatsapp?? '') == '0' ? 'selected' : '' }}>{{__('Inactive')}}</option>
                    </select>
                    @error('whatsapp')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="telegram">{{ __('telegram') }}</label>
                    <select name="telegram" id="telegram" class="form-control autorespon-channel">
                        <option value="true" {{ ($autorespon->telegram?? '') == '1' ? 'selected' : '' }}>{{__('Active')}}</option>
                        <option value="false" {{ ($autorespon->telegram?? '') == '0' ? 'selected' : '' }}>{{__('Inactive')}}</option>
                    </select>
                    @error('telegram')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
            <div class="col-lg-6">
            </div>
        </div>
    </div>
</div>