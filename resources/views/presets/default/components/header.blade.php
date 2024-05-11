@php
    $pages = App\Models\Page::all();
    $languages = App\Models\Language::all();
    $socials = getContent('social_icon.element', false);
@endphp
<!--========================== Header section Start ==========================-->
<div class="header-main-area">
    <div class="header" id="header">
        <div class="container position-relative">
            <div class="row">
                <div class="header-wrapper">

                    <div class="logo-wrapper">
                        <a href="{{route('home')}}" class="normal-logo"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normarl Logo')"></a>
                    </div>


                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            <li class="main-menu__menu-item"><a class="main-menu__menu-link {{ Route::is('home') ? 'active' : '' }}" href="{{route('home')}}">@lang('Home')</a></li>
                            @foreach ($pages as $page)
                                @if (($page->slug != 'contact') && ($page->slug != '/'))
                                <li class="main-menu__menu-item">
                                    <a class="main-menu__menu-link {{ (url()->current() == route('pages',[$page->slug])) ? 'active' : '' }}"  href="{{route('pages',$page->slug)}}">{{__($page->name)}}</a>
                                </li>
                                @endif
                            @endforeach

                            <li class="main-menu__menu-item"><a class="main-menu__menu-link {{ Route::is('contact') ? 'active' : '' }}" href="{{route('contact')}}">@lang('Contact')</a></li>
                            <li class="main-menu__menu-item">
                                <div class="header-language-wrap d-flex align-items-center">
                                    <div class="language-box ms-1">
                                        <select class="select langSel">
                                            @foreach ($languages as $lang)
                                                <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="menu-right-wrapper">
                            <ul>
                                <li class="responsive-bar"><i class="fas fa-bars sidebar-menu-show-hide"></i></li>
                                @guest()
                                    <li class="button-item"><a class='btn btn--base' href="{{route('user.login')}}"><i class="fas fa-user"></i> @lang('Sign In') </a></li>
                                @else
                                    <li class="button-item"><a href="{{route('user.auctionWishlist')}}" class='btn btn--base fav-btn'><i class="fas fa-heart"></i> <span class="wishlist-count">{{wishlistCount(auth()->user()->id)}}</span> </a></li>

                                    <li class="button-item"><a class='btn btn--base' href="{{route('user.home')}}"><i class="fas fa-tachometer-alt"></i> @lang('Dashboard') </a></li>
                                @endguest()
                            </ul>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

<!--========================== Header section End ==========================-->


 <!--========================== Sidebar mobile menu wrap Start ==========================-->
<div class="sidebar-menu-wrapper">
    <div class="top-close d-flex align-items-center justify-content-between mb-4">
        <div class="header-wrapper-siedebar">
            <div class="logo-wrapper">
                <a href="{{route('home')}}" class="normal-logo" id="footer-logo-normal"> <img src="{{ getImage('assets/images/general/logo.png') }}" alt="@lang('Normarl Logo')"></a>
            </div>
        </div>
        <i class="las la-times close-hide-show"></i>
    </div>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item {{ Route::is('home') ? 'active' : '' }}">
            <a href="{{route('home')}}" class="sidebar-menu-list__link">@lang('Home')</a>
        </li>
        @foreach ($pages as $page)
            @if (($page->slug != 'contact') && ($page->slug != '/'))
            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link {{ (url()->current() == route('pages',[$page->slug])) ? 'active' : '' }}"  href="{{route('pages',$page->slug)}}">{{__($page->name)}}</a>
            </li>
            @endif
        @endforeach

        <li class="sidebar-menu-list__item {{ Route::is('contact') ? 'active' : '' }}">
            <a href="{{route('contact')}}" class="sidebar-menu-list__link">@lang('Contact')</a>
        </li>
        <li class="sidebar-menu-list__item mb-2">
            <div class="language-box">
                <select class="select langSel">
                    @foreach ($languages as $lang)
                    <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                @endforeach
                </select>
            </div>
        </li>
        @guest()
        <li class="sidebar-menu-list__item d-flex justify-content-between">
            <a class="btn btn--base border-none mt-2 mb-2 ms-3" href="{{route('user.login')}}"><i class="fas fa-user"></i> @lang('Sign In') </a>
        </li>
        @else
        <li class="sidebar-menu-list__item d-flex">
            <a class="btn btn--base border-none mt-2 mb-2 ms-3 me-2" href="{{route('user.home')}}"><i class="fas fa-tachometer-alt"></i> @lang('Dashboard') </a>
            <a href="{{route('user.auctionWishlist')}}" class='btn border-none  btn--base fav-btn mt-2 mb-2 me-2'><i class="fas fa-heart"></i> <span class="wishlist-count">{{wishlistCount(auth()->user()->id)}}</span> </a>
        </li>
        @endguest()
    </ul>
</div>
<!--========================== Sidebar mobile menu wrap End ==========================-->
