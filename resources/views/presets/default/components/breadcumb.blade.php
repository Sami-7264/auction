@php
    $content = getContent('breadcumb.content', true);
@endphp
<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb">
    <img src="{{getImage(getFilePath('breadcumb').'/'. @$content->data_values->shape_image)}}" alt="shape" class="breadcumb-bg dark">
    <img src="{{getImage(getFilePath('breadcumb').'/'. @$content->data_values->shape_image_light)}}" alt="shape light" class="breadcumb-bg light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb__wrapper">
                    <h2 class="breadcumb__title">{{__($pageTitle) }}  </h2>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item"><a href="{{route('home')}}" class="breadcumb__link"> <i class="las la-home"></i> @lang('Home')</a> </li>
                        <li class="breadcumb__item"><i class="fas fa-chevron-right"></i> <i class="fas fa-chevron-right"></i></li>
                        <li class="breadcumb__item"> <span class="breadcumb__item-text"> {{__($pageTitle) }}  </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->
