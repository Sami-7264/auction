<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title> {{ $general->siteName(__($pageTitle)) }}</title>
        @include('includes.seo')
        <!-- Bootstrap CSS -->
        <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('assets/common/css/line-awesome.min.css')}}">

        <!-- Magnific Popup -->
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
        <!-- Custom Animation -->
        <!-- Slick -->
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/emojionearea.min.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
        <!-- Odometer -->
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom-animation.css')}}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/odometer.css')}}">


        @stack('style')

        @stack('style-lib')

        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
        <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    </head>
<body>

    <!--==================== Preloader Start ====================-->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="loader"> </div>
            </div>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
    <!-- ==================== Scroll to Top End Here ==================== -->




    @stack('fbComment')

    @include($activeTemplate.'components.header')
    @if(request()->route()->uri !='/')
       @include($activeTemplate.'components.breadcumb')
    @endif

    @yield('content')

    @include($activeTemplate.'components.footer')

    @php
        $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp
    @if(($cookie->data_values->status == 1) && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="d-flex justify-content-center">
            <div class="cookies-card hide text-center">
                <p class="cookies-card__content">{{ $cookie->data_values->short_desc }} <a class="text--base"
                        href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a> <a href="javascript:void(0)"
                        class="btn btn--base btn--sm border-none policy ms-4">@lang('Accept')</a></p>
            </div>
        </div>
    <!-- cookies dark version end -->
    @endif




    <!-- Login Modal -->
<div class="modal fade" id="login-upcomming-bid" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Login To Your Account')!</h1>
                <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>

            <form method="POST" action="{{ route('user.modal.login') }}" class="verify-gcaptcha">
                @csrf
                <input type="hidden" name="another" value="1">
                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-12">
                            <label for="login_email" class="form--label">@lang('Email or Username')</label>
                            <div class="form-group input-group">
                                <input id="login_email" type="text" name="username" class="form--control"  placeholder="@lang('Email or Username')" value="{{old('username')}}" required>
                                <div class="password-show-hide fas fa-user" ></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="password" class="form--label">@lang('Password')</label>
                            <div class="form-group input-group">
                                <input type="password" class="form--control" id="password" name="password" required="" placeholder="@lang('Password')">
                                <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <x-captcha></x-captcha>
                <button type="reset" class="btn--sm btn btn--base outline" data-bs-dismiss="modal">@lang('Close')</button>
                <button type="submit" id="recaptcha" class="btn btn--sm btn--base">@lang('Login')</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Login Modal  -->






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/common/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/common/js/bootstrap.bundle.min.js')}}"></script>


    <script src="{{asset($activeTemplateTrue.'js/moment.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
    <!-- Slick js -->
    <script src="{{asset($activeTemplateTrue.'js/slick.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/emojionearea.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/jquery.appear.min.js')}}"></script>
    <!-- Magnific Popup js -->
    <script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Odometer js -->
    <script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rangeSlider.js')}}"></script>
    <!-- Viewport js -->
    <script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>



    @stack('script-lib')

    @stack('script')

    @include('includes.plugins')

    @include('includes.notify')
    <!-- main js -->
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

    <script>
        (function ($){
            "use strict";
            $('.login-upcomming-bid').on('click', function() {
                var modal = $('#login-upcomming-bid');
                modal.modal('show');
            });


            $('.wishlist-btn').on('click', function(event) {
                event.preventDefault();
                var product_id = $(this).data('product_id');
                var $button = $(this);
                var $icon = $button.find("i");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{route('user.wishlist')}}',
                    data: {

                        product_id: product_id,

                    },
                    success: function (response) {

                        if(response.statusCode == 1)//removed
                        {
                            $icon.removeClass("fas fa-heart").addClass("far fa-heart");
                            $('.wishlist-count').text(response.wishlistCount);
                            Toast.fire({
                                icon: 'success',
                                title: response.status
                            });

                        }else if(response.statusCode == 2)//added
                        {
                            $icon.removeClass("far fa-heart").addClass("fas fa-heart");
                            $('.wishlist-count').text(response.wishlistCount);
                            Toast.fire({
                                icon: 'success',
                                title: response.status
                            });
                        }


                    },
                    error: function (error) {

                        Toast.fire({
                                icon: 'error',
                                title: response.status
                            });
                    }
                });

            });

        })(jQuery);
    </script>

<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        var inputElements = $('input,select');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });

    })(jQuery);
</script>


<script>
    $(document).ready(function() {
        "use strict";
        var countdownElements = $('.countdown');

        countdownElements.each(function() {
            var targetDate = $(this).data('date');
            console.log(targetDate);

            initializeCountdown($(this), targetDate);
        });

        function initializeCountdown(element, targetDate) {
            var targetTime = new Date(targetDate).getTime();

            if (isNaN(targetTime)) {
                console.error('Invalid date format:', targetDate);
                return;
            }

            function updateRemainingTime() {
                var now = new Date().getTime();
                var remainingTime = targetTime - now;

                var absRemainingTime = Math.abs(remainingTime);

                var days = Math.floor(absRemainingTime / (24 * 60 * 60 * 1000));
                var hours = Math.floor((absRemainingTime % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
                var minutes = Math.floor((absRemainingTime % (60 * 60 * 1000)) / (60 * 1000));
                var seconds = Math.floor((absRemainingTime % (60 * 1000)) / 1000);

                element.text(days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's');
            }

            updateRemainingTime();
            setInterval(updateRemainingTime, 1000);
        }
    });

</script>

</body>
</html>
