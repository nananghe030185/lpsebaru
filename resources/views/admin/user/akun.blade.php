<form class="row g-3 custom-input" action="{{ route('admin.user.update', $user->username) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form theme-form">
        <div class="row">
            <div class="col-12">
                <x-form.textgroup name="name" icon="icon-user" :value="isset($user->name) ? $user->name : old('name')" :required="true">{{__('Name')}}</x-form.textgroup>
            </div>
            <div class="col-12">
                <x-form.textgroup name="username" icon="icon-user" :value="isset($user->username) ? $user->username : old('Username')" :required="true">{{__('username')}}</x-form.textgroup>
            </div>
            <div class="col-12">
                <x-form.textgroup name="email" icon="icon-email" :value="isset($user->email) ? $user->email : old('email')" :required="true">{{__('Email')}}</x-form.textgroup>
            </div>
            <div class="col-12">
                <x-form.toggle name="status" :toggle="old('status', $user ?? '')" :value="old('status', $user->status ?? '')">Status</x-form.toggle>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <div class="card-wrapper border rounded-3 h-100 checkbox-checked">
                        <h6 class="sub-title">Group User</h6>
                        <div class="form-check radio radio-warning">
                            <input class="form-check-input" id="gmt" type="radio" name="group_id" value="4" @checked($user->group_id === 4)>
                            <label for="gmt">GMT</label>
                        </div>
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

    <div class="col-12 text-end d-inline-flex gap-1 justify-content-end">
        <x-form.buttonsimpan></x-form.buttonsimpan>
        <x-form.buttonbatal href="{{ route('admin.user.index')}}"></x-form.buttonbatal>
    </div>
</form>
