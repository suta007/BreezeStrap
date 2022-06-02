@extends('layouts.guest')

@section('content')
    <x-middle-card>
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" style="height:150px;">
            <div class="h4 fw-bold mt-3">
                {{ __('Confirm Password') }}
            </div>
        </div>

        <div class="fs-6 fw-bold text-dark mb-4 text-center">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>


        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-dark">
                        {{ __('Confirm Password') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </x-middle-card>
@endsection
