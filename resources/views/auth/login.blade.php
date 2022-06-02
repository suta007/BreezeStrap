@extends('layouts.guest')

@section('content')
    <x-middle-card>
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" style="height:150px;">
            <div class="h4 fw-bold mt-3">
                {{ __('Log in') }}
            </div>
        </div>
        @if (session('status'))
            <div class="fs-6 fw-bold text-success mb-4 text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="mt-4 px-5">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-bs-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('Username') }}</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                        id="username" placeholder="Username" value="{{ old('username') }}" autocomplete="username"
                        required autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" placeholder="Password" value="{{ old('password') }}" autocomplete="password"
                        required autofocus>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                @if (Route::has('password.request'))
                    <div class="mb-3">
                        <a style="text-decoration: none;" class="fw-bold text-black"
                            href="{{ route('password.request') }}">{{ __('Forgot Password') }}
                        </a>
                    </div>
                @endif

                <div class="mb-0 text-center">
                    @if (Route::has('register'))
                        <a class="btn btn-outline-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif

                    <button type="submit" class="btn btn-dark">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </x-middle-card>
@endsection
