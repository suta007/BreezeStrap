@extends('layouts.guest')

@section('content')
    <x-middle-card style="width:700px;">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" style="height:150px;">
            <div class="h4 fw-bold mt-3">
                {{ __('Reset Password') }}
            </div>
        </div>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-dark">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>


    </x-middle-card>
@endsection
