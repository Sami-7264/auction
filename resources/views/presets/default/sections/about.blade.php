@php
    $content = getContent('about.content', true);
@endphp

<!--========================== About Section Start ==========================-->
<div id="about" class="about-section py-120">
    <div class="container">
        <div class="row flex-wrap-reverse align-items-center gy-4">

            <div class="col-lg-5">
                <div class="about-thumb">
                    <div class="about-thumb__inner">
                            <img class="img-2" src="{{getImage(getFilePath('about').'/'. @$content->data_values->about_image)}}" alt="image">

                        <div class="about-popup-video-wrap">
                            <div class="popup-vide-wrap">
                                <div class="video-main">
                                    <div class="promo-video">
                                        <div class="waves-block">
                                            <div class="waves wave-1"></div>
                                            <div class="waves wave-2"></div>
                                            <div class="waves wave-3"></div>
                                        </div>
                                    </div>
                                    <a class="play-video popup_video" data-fancybox="" href="{{@$content->data_values->url}}">
                                        <span class="play-btn"> <i class="fa fa-play"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="about-right-content">
                    <div class="section-heading left-content">
                        <div class="section-heading__border">
                            <span class="one"></span>
                            <span class="two"></span>
                            <span class="three"></span>
                        </div>
                        <h2 class="section-heading__title">{{__(@$content->data_values->heading)}}</h2>
                        <p class="section-heading__desc mb-4 wyg">{{__(@$content->data_values->subheading)}}</p>
                        <a href="{{route('product')}}" class="btn btn--base me-3 mb-3">
                            @lang('Get Started Now')
                        </a>
                </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--========================== About Section End ==========================-->
