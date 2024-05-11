@php
    $homeOneContent        = getContent('homeone.content',true);
    $homeTwoContent        = getContent('hometwo.content',true);
    $homeThreeContent        = getContent('homethree.content',true);
    $general = gs();
    $page = App\Models\Page::where('slug', 'about')->first();


@endphp
@extends($activeTemplate.'layouts.frontend')
@section('content')

{{-- Home Section One Start --}}

@if($general->homesection == 1)
<section class="banner-section bg-img">
    <img class="banner-shape" src="{{ activeTemplate(true).'/images/banner-shap-dark.png'}}" alt="@lang('shape')">
    <img class="banner-shape light-img" src="{{ activeTemplate(true).'/images/banner-shap-light.png'}}" alt="@lang('shape')">
    <div class="container position-relative">
        <div class="banner-effect"></div>
        <div class="banner-effect_two"></div>
        <div class="row gy-4">
            <div class="col-lg-6 col-md-12">
                <div class="banner-left__content">
                    <h2>{{__(@$homeOneContent->data_values->heading)}}</h2>
                    <p>
                        {{__(@$homeOneContent->data_values->subheading)}}
                    </p>

                    <div class="button-wrap">
                        <a href="{{route('product')}}" class="btn btn--base me-3 mb-3">
                            @lang('Get Started Now')
                        </a>
                        <a href="{{route('pages',$page->slug)}}" class="btn btn--base two me-3 mb-3">
                            @lang('About Us')
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 position-relative">
                <div class="banner-right-wrap">
                    <div class="main-banner-img">
                        <img src="{{getImage(getFilePath('homeone').'/'.@$homeOneContent->data_values->banner_image)}}" alt="@lang('main-image')">
                        <img  class="banner-shape-right animate-x-axis" src="{{getImage(getFilePath('homeone').'/'.@$homeOneContent->data_values->right_shape_image)}}" alt="@lang('shape image')">
                        <img class="banner-shape-left animate-y-axis" src="{{getImage(getFilePath('homeone').'/'.@$homeOneContent->data_values->left_shape_image)}}" alt="@lang('shape image')">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
{{-- Home Section One End --}}


{{-- Home Section Three Start --}}
@if($general->homesection == 2)
<section class="banner-section banner-three bg-img">
    <div class="container position-relative">
        <img  class="banner-3-left-top animate-x-axis" class="banner-shape-" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->left_top_image)}}" alt="@lang('Shape')">
        <img class="banner-3-right-top animate-y-axis" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->right_top_image)}}" alt="@lang('Shape')">
        <img class="banner-3-left-bottom animate-y-axis" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->left_bottom_image)}}" alt="@lang('Shape')">
        <img class="banner-3-right-bottom animate-x-axis" src="{{getImage(getFilePath('homethree').'/'.@$homeThreeContent->data_values->right_bottom_image)}}" alt="@lang('Shape')">
        <div class="banner-effect"></div>
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-7 col-xl-6 col-md-12">
                <div class="banner-left__content text-center">
                    <h2>{{__(@$homeThreeContent->data_values->heading)}}</h2>
                    <p>
                        {{__(@$homeThreeContent->data_values->subheading)}}
                    </p>

                    <div class="button-wrap">
                        <a href="{{route('product')}}" class="btn btn--base two me-3 mb-3">
                            @lang('Get Started Now')
                        </a>
                        <a href="{{route('pages',$page->slug)}}" class="btn btn--base me-3 mb-3">
                            @lang('About Us')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
{{-- Home Section Three End --}}

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
