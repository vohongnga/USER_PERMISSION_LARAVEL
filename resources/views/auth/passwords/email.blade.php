@extends('auth.template')
@section('title', __('messages.forget_password'))
@section('content')
<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
    <div class="kt-login__container py-4 px-5 bg-white">
        <div class="title-login mt-3 text-center">
            <h4 class="mx-auto font-weight-bold cl-black">
                    {{ session('status') ? __('messages.completed_reset_email') : __('messages.forget_password') }}
            </h4>
        </div>
        <div class="kt-login__signin mt-5">
            <p class="text-center cl-black">{{ session('status') ? __('messages.enter_your_email_address_in_the_password') : __('messages.please_enter_your_email_address') }}</p>
            <p class="text-center cl-black">{{ session('status') ? __('messages.we_have_sent_you_an_email') : __('messages.if_you_enter_an_email_address') }}</p>
            <p class="text-center cl-black">{{ session('status') ? '' : __('messages.we_will_send_you_an_email_with_the_link') }}</p>
            @if (session('status'))
                <p class="text-center cl-black">{{  __('messages.if_you_do_not_receive_a_reset_email') }}</p>
                <p class="text-center cl-black">{{  __('messages.please_confirm_the_removal_of_the_setting_domain') }}</p>
            @else
            <form class="mb-0" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label class="cl-silver-chalice" for="email">{{ __('messages.email') }}</label>
                    <input class="form-control mt-0 @error('email') is-invalid @enderror" id="email" type="email" placeholder="{{ __('messages.email') }}" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="kt-login__actions">
                    <button type="submit" id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary w-100 font-weight-bold">{{ __('messages.submit') }}</button>
                </div>
            </form>
            @endif
        <div class="mt-4 text-center">
            <a class="forgot-pass cl-mariner fw-300 font-weight-bold" href="{{ route('login') }}">{{ __('messages.back_to_the_login_screen') }}</a>
        </div>
    </div>
</div>
@endsection
