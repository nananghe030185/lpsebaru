<form class="row g-3 custom-input" action="{{ route('app.user.update', $user->username) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form theme-form">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label>Name<span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="icon-user"></i>
                        </div>
                        <input class="form-control" type="text" id="name" value="{{ isset($user->name) ? $user->name : old('name') }}" name="name" placeholder="Enter Name">
                        @error('name')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
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
                        <input class="form-control" type="text" id="username" value="{{ isset($user->username) ? $user->username : old('username') }}" name="username" placeholder="Enter Username">
                        @error('username')
                            <p class="text-danger">{{ $message }}</p>
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
                        <input class="form-control" type="email" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}" name="email" placeholder="Enter Email">
                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
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
