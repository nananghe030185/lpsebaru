<form class="row g-3 custom-input" action="{{ route('app.user.update', $user->username) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form theme-form custom-input">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label>Name<span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="icon-user"></i>
                        </div>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" value="{{ isset($user->name) ? $user->name : old('name') }}" name="name" placeholder="Enter Name">
                        @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label>Username<span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="icon-user"></i>
                        </div>
                        <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" value="{{ isset($user->username) ? $user->username : old('username') }}" name="username" placeholder="Enter Username">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label>Email<span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="icon-email"></i>
                        </div>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" name="email" placeholder="Enter Email">
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="icon-lock"></i>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" value="" name="password" placeholder="Masukan password baru jika ingin dirubah atau biarkan kosong">
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-end d-inline-flex gap-1 justify-content-end">
        <x-form.buttonsimpan></x-form.buttonsimpan>
        <x-form.buttonbatal href="{{ route('app.dashboard.index')}}"></x-form.buttonbatal>
    </div>
</form>
