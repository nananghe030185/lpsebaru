<form class="row g-3 custom-input" action="{{ route('admin.user.update', $user->username) }}" method="POST" enctype="multipart/form-data">
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
            <div class="col-12">
                <div class="mb-3">
                    <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                        <h6 class="sub-title">Group User</h6>
                        <div class="form-check radio radio-danger">
                            <input class="form-check-input" id="nonmember" type="radio" name="group_id" value="3" @checked($user->group_id === 3)>
                            <label for="nonmember">Non Member</label>
                        </div>
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="member" type="radio" name="group_id" value="2" @checked($user->group_id === 2)>
                            <label for="member">Member</label>
                        </div>
                        <div class="form-check radio radio-info">
                            <input class="form-check-input" id="superadmin" type="radio" name="group_id" value="1" @checked($user->group_id === 1)>
                            <label for="superadmin">Super Admin</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">{{__('Simpan')}}</button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">{{__('Kembali')}}</a>
    </div>
</form>
