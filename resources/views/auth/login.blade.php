@extends('auth.template')
@section('title', __('messages.login'))
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
    <div class="kt-login__container py-4 px-5 bg-white">
        <div class="title-login mt-3 text-center">
            <h4 class="mx-auto font-weight-bold">{{  __('messages.login') }}</h4>
        </div>
        <div class="kt-login__signin mt-5">
            <form class="kt-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('messages.email') }}</label>
                    <input class="form-control mt-0 @error('email') is-invalid @enderror border bg-transparent" id="email" type="text" placeholder="{{ __('messages.email') }}" name="email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('messages.password') }}</label>
                    <input class="form-control mt-0 @error('password') is-invalid @enderror border bg-transparent" id="password" type="password" placeholder="{{ __('messages.password') }}" name="password" value="{{ old('password') }}">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                    </span>
                    @enderror
                </div>
                <div class="kt-login__actions">
                    <button type="submit" id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary w-100 font-weight-bold">{{ __('messages.login') }}</button>
                </div>
            </form>

            @if (Route::has('register'))
            <div class="kt-login__account">
                <span class="kt-login__account-msg">
					{{ __('messages.dont_have_account') }}
                </span>
                <a href="{{ route('register') }}" id="kt_login_signup" class="kt-login__account-link">{{ __('messages.sign_up') }}</a>
            </div>
            @endif

            @if (Route::has('password.request'))
            <div class="mt-4 text-center">
                <a class="forgot-pass cl-mariner fw-300 font-weight-bold" href="{{ route('password.request') }}">{{ __('messages.forget_password') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
