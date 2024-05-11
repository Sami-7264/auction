@php
    $policyPages    = getContent('policy_pages.element');
    $socials = getContent('social_icon.element', false);
    $contactContent = getContent('contact_us.content', true);
    $subscribeContent = getContent('subscribe.content', true);
    $importantLink = getContent('footer_important_links.element', false, null, true);
    $companyLink = getContent('footer_company_links.element', false, null, true);
@endphp

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area">
    <span class="banner-effect-1"></span>
    <div class="pt-120">
        <div class="container">
            <div class="row justify-content-center gy-5">
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{route('home')}}" class="footer-logo-normal"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normal Logo')"></a>
                            <a href="{{route('home')}}" class="footer-logo-dark hidden"> <img src="{{ getImage('assets/images/general/logo_white.png') }}" alt="@lang('Dark Logo')"></a>
                        </div>
                        <div class="footer-item__desc">@php echo $contactContent->data_values->website_descripton; @endphp</div>
                        <div class="login-social-wrap">
                            <ul class="social-list mb-3">
                                @foreach($socials as $item)
                                <li class="social-list__item">
                                    <a href="{{$item->data_values->url}}" class="social-list__link">@php echo $item->data_values->social_icon; @endphp</a>
                                </li>
                                @endforeach
                            </ul>
                          </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 footer-item-wrapper">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Company Link')</h5>
                        <div class="title-border">
                            <span class="long"></span>
                            <span class="short"></span>
                        </div>
                        <ul class="footer-menu">
                            @foreach($companyLink as $item)
                            <li class="footer-menu__item"><a href="{{url('/').$item->data_values->url}}" class="footer-menu__link">{{ __(@$item->data_values->title) }}</a> </li>
                            @endforeach
                            @foreach ($policyPages as $link)
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('policy.pages',[slug($link->data_values->title),$link->id]) }}">{{ __(@$link->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 footer-item-wrapper">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Important links')</h5>
                        <div class="title-border">
                            <span class="long"></span>
                            <span class="short"></span>
                        </div>
                        <ul class="footer-menu">
                            @foreach($importantLink as $item)
                            <li class="footer-menu__item"><a href="{{url('/').$item->data_values->url}}" class="footer-menu__link">{{ __(@$item->data_values->title)}}</a> </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 footer-item-wrapper">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Contact Information') </h5>
                        <div class="title-border">
                            <span class="long"></span>
                            <span class="short"></span>
                        </div>
                        <ul class="footer-contact-menu">
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{__(@$contactContent->data_values->address)}}</p>
                                </div>
                            </li>
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p><a href="mailto:{{__(@$contactContent->data_values->email)}}">{{__(@$contactContent->data_values->email)}}</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-border-bottom"></div>
        </div>
    </div>
  <!-- Footer Top End-->

  <div class="bottom-footer py-3">
    <div class="container">
        <div class="row justify-content-center gy-2">
            <div class="col-lg-6 col-md-12">
                <div class="bottom-footer-tex text-center">
                    @php echo $contactContent->data_values->website_footer; @endphp
                </div>
            </div>
        </div>
    </div>
</div>

</footer>
  <!-- ==================== Footer End Here ==================== -->
