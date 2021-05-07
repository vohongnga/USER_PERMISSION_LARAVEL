@extends('auth.template')
@section('title', __('messages.reset_password'))
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
    <div class="kt-login__container py-4 px-5 bg-white">
        <div class="title-login mt-3 text-center">
            <h4 class="mx-auto font-weight-bold cl-black">{{  __('messages.reset_password') }}</h4>
        </div>
        <div class="kt-login__signin mt-5">
            <p class="text-center cl-black mb-4">{{ __('messages.set_a_new_password') }}</p>
            <form class="" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group">
                    <label for="password" class="cl-silver-chalice">{{ __('messages.new_password') }}</label>
                    <input class="form-control mt-0 @error('password') is-invalid @enderror" id="password" type="password" placeholder="{{ __('messages.new_password') }}" name="password" value="{{ old('password') }}">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-0">
                    <label for="password-confirm" class="fs-13 cl-000 fw-600 cl-silver-chalice">{{ __('messages.re_new_password') }}</label>
                    <input id="password-confirm" type="password" class="form-control mt-0 border-05" name="password_confirmation" placeholder="{{ __('messages.re_new_password') }}" autocomplete="new-password">
                    <p class="cl-black mt-3">{{ __('messages.enter_password_using_8_alphanumeric_characters') }}</p>
                </div>
                <div class="kt-login__actions">
                    <button type="submit" id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary w-100 font-weight-bold">{{ __('messages.to_set_password') }}</button>
                </div>
            </form>
            <div class="mt-3 text-center">
                <a class="forgot-pass cl-mariner fw-300 font-weight-bold" href="{{ route('login') }}">{{ __('messages.back_to_the_login_screen') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
