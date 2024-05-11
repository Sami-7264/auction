@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $credentials = $general->socialite_credentials;
@endphp
  <!--=======-** Login start **-=======-->
  <section class="account bg-img login py-120 position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Welcome back')</h3>
                        </div>
                        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Email or Username')</label>
                                    <div class="form-group input-group">
                                        <input type="text" class="form--control" name="username" value="{{ old('username') }}" placeholder="@lang('Email/Username')">
                                        <div class="password-show-hide far fa-user "></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control form--control" required name="password" placeholder="@lang('password')">
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"> </div>
                                    </div>
                                </div>
                                  <x-captcha></x-captcha>
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="forgot-password">@lang('Forgot Your Password?')</a>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" id="recaptcha" class="btn btn--base w-100 mt-4 mb-4">
                                        @lang('Sign In')
                                    </button>
                                </div>

                                @if ($credentials->google->status == 1 || $credentials->facebook->status == 1 || $credentials->linkedin->status == 1)
                                <div class="col-sm-12 mb-3">
                                    <div class="login-border-wrap">
                                    <span class="login-border"></span> <span>@lang('or')</span> <span class="login-border"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="login-social-wrap">
                                        <ul class="social-list mb-3">
                                            @if ($credentials->facebook->status == 1)
                                            <li class="social-list__item">
                                                <a href="{{ route('user.social.login', 'facebook') }}" class="social-list__link"> <i class="fab fa-facebook-f"></i></a>
                                            </li>
                                            @endif

                                            @if ($credentials->google->status == 1)
                                            <li class="social-list__item">
                                                <a href="{{ route('user.social.login', 'google') }}" class="social-list__link"> <i class="fab fa-google"></i></a>
                                            </li>
                                            @endif

                                            @if ($credentials->linkedin->status == 1)
                                            <li class="social-list__item">
                                                <a href="{{ route('user.social.login', 'Linkedin') }}" class="social-list__link"> <i class="fab fa-linkedin-in"></i></a>
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                                @endif

                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang('Don\'t have any account?') <a href="{{ route('user.register') }}" class="have-account__link">@lang('Create Account')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=======-** Login End **-=======-->
@endsection
