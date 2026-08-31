@extends('layouts.authentication.master')

@section('title', 'Login')

@section('css')
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div>
                            <a class="logo text-center" href="{{ route('admin.dashboard') }}">
                                <img class="img-fluid for-light w-10 h-5" src="{{ asset('assets/images/logo/logo_LPSE.png') }}" alt="looginpage" width="200px">
                                <img class="img-fluid for-dark w-10 h-5" src="{{ asset('assets/images/logo/logo_LPSE.png') }}" alt="looginpage"  width="200px">
                            </a>
                        </div>
                        
                        <div class="login-main">
                            {{-- Alert --}}
                            @if (Session::has('error'))
                                <div class="alert txt-danger border-danger alert-dismissible fade show" role="alert">
                                    <i data-feather="alert"></i>
                                        {{ Session::get('error') }}
                                        <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- End Alert --}}
                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <h4>Sign in</h4>
                                <p>Masukkan email dan password Anda</p>
                                <div class="form-group">
                                <label class="col-form-label">Alamat Email</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror" type="email" required="" placeholder="masukan email anda" value="{{ old('email')}}" autofocus>
                                    @error('email')
                                        <div class="small-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required=""
                                            placeholder="*********">
                                        <div class="show-hide"><span class="show"> </span></div>
                                        @error('password')
                                            <div class="small-text text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="form-check">
                                        <input class="checkbox-primary form-check-input" id="checkbox1" type="checkbox" name="remember">
                                        <label class="text-muted form-check-label" for="checkbox1">Ingat password</label>
                                    </div><a class="link" href="{{ route('password.store') }}">Lupa password?</a>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Sign in</button>
                                    </div>
                                </div>
                                <p class="mt-4 mb-0 text-center">Tidka punya akun ?<a class="ms-2"
                                        href="{{ route('register') }}">Buat Akun</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
 <script>
        $(document).on('click', '#error', function(e) {
          if($('.email').val() == '' || $('.pwd').val() == ''){
          swal(
            "Error!", "Sorry, looks like some data are not filled, please try again !", "error"           
          )
          }
        });
      </script>
@endsection
