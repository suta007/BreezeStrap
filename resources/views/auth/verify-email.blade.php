@extends('layouts.guest')

@section('content')
    <x-middle-card style="width:700px;">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" style="height:150px;">
            <div class="h4 fw-bold mt-3">
                {{ __('Verify Your Email Address') }}
            </div>
        </div>
        <div class="text-dark fs-6 mb-4">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="fs-6 fw-bold text-success mb-4">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="d-inline-flex float-end mt-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn btn-dark" type="submit">{{ __('Resend Verification Email') }}</button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="ms-2">
                @csrf
                <button type="submit" class="btn btn-outline-dark">{{ __('Log Out') }}</button>
            </form>
        </div>
    </x-middle-card>
@endsection
