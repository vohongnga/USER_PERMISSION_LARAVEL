@extends('auth.template')
@section('title', __('messages.password_reset_completed'))
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
    <div class="kt-login__container py-4 px-5 bg-white">
        <div class="title-login mt-3 text-center">
            <h4 class="mx-auto font-weight-bold">{{  __('messages.password_reset_completed') }}</h4>
        </div>
        <div class="kt-login__signin mt-5">
            <p class="text-center mb-4">{{ __('messages.the_new_password_has_been_set') }}</p>
            <div class="mt-3 text-center">
                <a class="forgot-pass cl-mariner fw-300 font-weight-bold" href="{{ route('login') }}">{{ __('messages.back_to_the_login_screen') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
