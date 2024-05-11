@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $policyPages = getContent('policy_pages.element',false,null,true);
    $credentials = $general->socialite_credentials;
@endphp

    <!-- Registration Start Here  -->
<section class="account py-120 position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> @lang('Sign Up Your Account') </h3>
                        </div>
                        <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-3">
                                @if(session()->get('reference') != null)
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="referenceBy" class="form-label">@lang('ReferenceBy')</label>
                                        <input type="text" name="referBy" id="referenceBy" class="form--control" value="{{session()->get('reference')}}" readonly placeholder="@lang('Reference')">
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Username')</label>
                                     <div class="form-group input-group">
                                        <input type="text" class="form--control checkUser" name="username" value="{{ old('username') }}" required placeholder="@lang('Username')">
                                        <small class="text-danger usernameExist"></small>
                                        <div class="password-show-hide far fa-user "></div>
                                     </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Email')</label>
                                    <div class="form-group input-group">
                                        <input type="email" class="form--control checkUser" name="email" value="{{ old('email') }}" required placeholder="@lang('Email')">
                                        <div class="password-show-hide fas fa-envelope"></div>
                                     </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control form--control" name="password" required>
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"> </div>
                                        @if($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Confirm Password')</label>
                                    <div class="input-group">
                                        <input id="password_confirmation" type="password" class="form-control form--control" name="password_confirmation" required>
                                        <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password_confirmation"> </div>
                                    </div>
                                </div>

                                <x-captcha></x-captcha>

                                @if($general->agree)
                                <div class="col-sm-12">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                        <div class="form-check-label">
                                            <label for="agree"> @lang('I agree with Licences Info'),</label>
                                            @foreach($policyPages as $policy) <a class="policy" href="{{ route('policy.pages',[slug($policy->data_values->title),$policy->id]) }}">{{ __($policy->data_values->title) }}</a> @if(!$loop->last), @endif @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif


                                <div class="col-sm-12 mt-4 mb-4">
                                    <button type="submit" id="recaptcha" class="btn btn--base w-100">
                                        @lang('Sign Up')
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
                                        <p class="have-account__text">@lang('Already Have An Account?') <a href="{{ route('user.login') }}" class="have-account__link">@lang('Login Now')</a></p>
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
<!-- Registration End Here  -->


<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="existModalLongTitle">@lang('You are with us')</h5>
                <span class="close" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <p>@lang('You already have an account please Login ')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--sm btn--base two" data-bs-dismiss="modal">@lang('Close')</button>
                <a href="{{ route('user.login') }}" class="btn btn--sm btn--base">@lang('Login')</a>
            </div>
        </div>
    </div>
</div>


@endsection
@push('style')
<style>
    /* .country-code .input-group-text{
        background: #fff !important;
    } */
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
    .modal-content{
        background-color:hsl(var(--black)) !important;
    }

</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
      "use strict";
        (function ($) {
            @if($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });

                $('[name=password]').focus(function () {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function () {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });


            @endif

            $('.checkUser').on('focusout',function(e){
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response.data != false){
                    $(`.${response.type}Exist`).text(`${response.type.charAt(0).toUpperCase()}${response.type.slice(1)} already exist`);
                  }else{
                    $(`.${response.type}Exist`).text('');
                  }
                });
            });
        })(jQuery);

    </script>
@endpush
