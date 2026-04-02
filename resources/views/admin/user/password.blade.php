<div class="form theme-form">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label>Password<span>*</span></label>
                <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password"
                    autocomplete="off">
                @error('password')
                    <span class="text-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label>Confirm Password<span>*</span></label>
                    <input class="form-control" type="password" id="confirm_password" name="confirm_password"
                        placeholder="Enter Confirm Password" autocomplete="off">
                    @error('confirm_password')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div>
                <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
            </div>
        </div>
    </div>
</div>