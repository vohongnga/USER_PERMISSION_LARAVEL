@extends('auth.template')
@section('title', __('messages.register'))
@section('content')
    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
        <div class="kt-login__container py-4 px-5 bg-white">
            <div class="title-login mt-3 text-center">
                <h4 class="mx-auto font-weight-bold">{{ __('Register') }}</h4>
            </div>
            <div class="kt-login__signin mt-5">
                <form class="kt-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('messages.name') }}</label>
                        <input id="name" class="form-control mt-0 @error('name') is-invalid @enderror border bg-transparent" type="text" placeholder="{{ __('messages.name') }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <span>{{ $message }}</span>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('messages.email') }}</label>
                        <input id="email" class="form-control mt-0 @error('email') is-invalid @enderror border bg-transparent" type="text" placeholder="{{ __('messages.email') }}" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <span>{{ $message }}</span>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('messages.password') }}</label>
                        <input class="form-control mt-0 @error('password') is-invalid @enderror border bg-transparent" id="password" type="password" placeholder="{{ __('messages.password') }}" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <span>{{ $message }}</span>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">{{ __('messages.password_confirmation') }}</label>
                        <input class="form-control mt-0 @error('password_confirmation') is-invalid @enderror border bg-transparent" id="password_confirmation" type="password" placeholder="{{ __('messages.password_confirmation') }}" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <span>{{ $message }}</span>
                        </span>
                        @enderror
                    </div>

                    <div class="kt-login__actions">
                        <button type="submit" id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary w-100 font-weight-bold">{{ __('messages.register') }}</button>
                    </div>
                    <div class="mt-4 text-center">
                        <a class="forgot-pass cl-mariner fw-300 font-weight-bold" href="{{ route('login') }}">{{ __('messages.back_to_the_login_screen') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
