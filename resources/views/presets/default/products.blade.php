@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="product-details-area py-120">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-4">

                <div class="blog-sidebar-wrapper product-sidebar">
                    <div class="blog-sidebar">

                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Product Search') </h5>
                            <div class="blog-sidebar__filter-wrap">
                                <div class="col-sm-12">
                                    <label class="form-label">@lang('Title')</label>
                                    <div class="form-group input-group">
                                        <input type="text" class="form--control" id="searchTitle" name="search" value="{{ old('search') }}" placeholder="@lang('Search')">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Filters') </h5>
                            <h5 class="blog-sidebar__sub-title"> @lang('Sort By') </h5>
                            <div class="blog-sidebar__filter-wrap">
                                <div class="form-check rounded mb-3">
                                    <input class="form-check-input" type="radio" name="sorted_by_date" id="sorted_by_date" value="date">
                                    <div class="form-check-label">
                                        <label for="sorted_by_date">@lang('Date')</label>
                                    </div>
                                </div>
                                <div class="form-check rounded mb-3">
                                    <input class="form-check-input" type="radio" name="sorted_by_price" id="sorted_by_price" value="price">
                                    <div class="form-check-label">
                                        <label for="sorted_by_price">@lang('Price')</label>
                                    </div>
                                </div>
                                <div class="form-check rounded mb-3">
                                    <input class="form-check-input" type="radio" name="sorted_by_name" id="sorted_by_name" value="name">
                                    <div class="form-check-label">
                                        <label for="sorted_by_name">@lang('Name')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('Price By') </h5>
                            <h5 class="blog-sidebar__sub-title">@lang('Price')</h5>
                            <div class="advance_search_input mb-5">
                                <div class="range-slider">
                                    <div id="price-range" data-min="0" data-max="{{$productMaxPrice}}" data-unit="$"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <input type="hidden" name="min" id="min">
                            <input type="hidden" name="max" id="max">
                        </div>

                        <div class="side-bar-item">
                            <h5 class="blog-sidebar__title"> @lang('By Category') </h5>
                            <div class="blog-sidebar__category-wrap">
                                @forelse($categories as $category)
                                <div class="item">
                                    <div class="form-check rounded mb-3">
                                        <input class="form-check-input filtered_category" name="categories_{{$loop->index}}" type="checkbox" value="{{$category->id}}" id="categories_{{$loop->index}}">
                                        <div class="form-check-label">
                                            <label for="categories_{{$loop->index}}">{{__($category->name)}}</label>
                                        </div>
                                    </div>
                                </div>
                                @empty

                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================= Blog Details Sidebar End ======================== -->
            </div>
            <div class="col-lg-8 filtered-product">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-12">
                        <div class=" search-boarder border-radious-5 mb-2">
                            <p>@lang('Showing Results'): {{@$products->count()}}</p>
                        </div>
                    </div>

                    @forelse($products as $product)
                    <div class="col-lg-6 col-md-6">
                        <div class="product">
                            <div class="product__thumb">
                                <a href="{{ route('product.details', [slug($product->title),$product->id])}}">

                                    <div class="product-details-slider product-slider-active">
                                        @forelse($product->productImages as $image)
                                        <div class="product-single-slider">
                                            <img src="{{ getImage(getFilePath('product') . '/'.@$image->path .'/'.@$image->image)}}" alt="@lang('Auction Product')">
                                        </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </a>
                            </div>
                            <div class="product__top">
                                <div class="site-title">
                                    <a href="{{ route('product.details', [slug($product->title),$product->id])}}">{{__(@$product->title)}}</a>
                                </div>
                                <span class="product__price">{{$general->cur_sym}}{{showAmount($product->price,0)}}</span>
                            </div>
                            <div class="product__body">
                                <div class="price-item">
                                    <p class="price-title">@lang('HIGHEST BID')</p>
                                    <div class="price">
                                        <span class="icon"><i class="fas fa-caret-up"></i></span><p>
                                            {{$general->cur_sym}}{{showAmount(highestBidCount($product->id), 0)}}
                                        </p>
                                    </div>
                                </div>
                                <div class="price-item">
                                    <p class="price-title">@lang('TOTAL BIDS')</p>
                                    <div class="price">
                                        <span class="icon"><i class="far fa-user"></i></span><p>{{totalBidCount($product->id)}}</p>
                                    </div>
                                </div>
                                @if($product->started_at < now())
                                <div class="price-item">
                                    <p class="price-title">@lang('TIME LEFT')</p>
                                    <div class="price">
                                        <span class="icon"><i class="far fa-clock"></i></span>

                                        <p>
                                            @if($product->expired_at > now())
                                                <span id="countdown_{{ $product->id }}" class="countdown" data-date="{{ showDateTime($product->expired_at, 'm/d/Y H:i:s') }}"></span>
                                            @else
                                                <span>@lang('Closed')</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="price-item">
                                    <p class="price-title">@lang('START TIME')</p>
                                    <div class="price">
                                        <span class="icon"><i class="far fa-clock"></i></span>

                                        <p>
                                            <span id="countdown_{{ $product->id }}" class="countdown" data-date="{{ showDateTime($product->started_at, 'm/d/Y H:i:s') }}"></span>
                                        </p>

                                    </div>
                                </div>
                            @endif
                            </div>
                            <div class="product__bottom">

                                <a href="{{ route('product.details', [slug($product->title),$product->id])}}">
                                    <button class="product-btn">@lang('Details')</button>
                                </a>

                                @auth()
                                    @if($product->getWishlist)
                                        @if($product->getWishlist->user_id == auth()->user()->id && $product->id == $product->getWishlist->product_id)
                                            <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon  wishlist-btn"><i class="fas fa-heart"></i></a>
                                        @else
                                            <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon  wishlist-btn"><i class="far fa-heart"></i></a>
                                        @endif

                                    @else
                                        <a href="javascript:void(0)" data-product_id="{{$product->id}}" class="love-icon  wishlist-btn"><i class="far fa-heart"></i></a>
                                    @endif
                                @else
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login-upcomming-bid" class="login-upcomming-bid love-icon"><i class="far fa-heart"></i></a>
                                @endauth


                            </div>
                        </div>
                    </div>
                    @empty

                    @endforelse

                </div>

                <!-- pagination -->
                <div class="row {{ $products->hasPages() ? 'pt-5' : '' }}">
                    <div class="col-lg-12 justify-content-end d-flex">
                        @if ($products->hasPages())
                        <div class="Page navigation example">
                            @php echo paginateLinks($products) @endphp
                        </div>
                        @endif
                    </div>
                </div>
                <!-- / pagination -->
            </div>

        </div>
    </div>
</section>

<!-- ==================== Product End Here ==================== -->




@endsection




@push('script')
    <script>
        "use strict";

        $("#price-range").each(function () {

            var dataMin = $(this).attr('data-min');
            var dataMax = $(this).attr('data-max');
            var dataUnit = $(this).attr('data-unit');

            $(this).append("<input type='text' class='first-slider-value' disabled/><input type='text' class='second-slider-value' disabled/>");

            $(this).slider({
                range: true,
                min: dataMin,
                max: dataMax,
                values: [dataMin, dataMax],
                slide: function (event, ui) {
                    event = event;
                    $(this).children(".first-slider-value").val(dataUnit + ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $(this).children(".second-slider-value").val(dataUnit + ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

                    $("#min").val(ui.values[0]),
                    $("#max").val(ui.values[1]);
                },
                change: function() {
                    var min = $('input[name="min"]').val();
                    var max = $('input[name="max"]').val();

                    var categories = [];
                    var shortBy = [];
                    var search = [];

                    fetchData(min, max, categories, shortBy, search);
                }
            });

            $(this).children(".first-slider-value").val(dataUnit + $(this).slider("values", 0).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            $(this).children(".second-slider-value").val(dataUnit + $(this).slider("values", 1).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        });


        $("input[type='checkbox'][name^='categories_']").on('click', function() {
            var categories   = [];
            var shortBy = [];
            var min = [];
            var max = [];
            var search = [];
            $('input[type="checkbox"][name^="categories_"]:checked').each(function() {
                if (!categories.includes(parseInt($(this).val()))) {
                    categories.push(parseInt($(this).val()));
                }
            });
            fetchData(min,max,categories,shortBy,search);
        });



        $('input[type="radio"][name^="sorted_by_"]').on('change', function() {
            var shortBy = $(this).val();
            $('input[type="radio"][name^="sorted_by_"]').not(this).prop('checked', false);
            var categories   = [];
            var min = [];
            var max = [];
            var search = [];

            fetchData(min,max,categories,shortBy, search);
        });

        $("#searchTitle").on('keyup', function () {
            var categories   = [];
            var min = [];
            var max = [];
            var shortBy = [];

            var search = $(this).val();
            fetchData(min,max,categories,shortBy, search);
        });

        function fetchData(min,max,categories,shortBy,search){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "get",
                url: "{{ route('fetch.product') }}",
                data:{
                    "categories": categories,
                    "shortBy": shortBy,
                    "min":min,
                    "max":max,
                    "search": search,
                },
                dataType: "json",
                success: function (response) {
                    if(response.html){
                        $('.filtered-product').html(response.html);
                        runCountDown();
                    }

                    if(response.error){
                        notify('error', response.error);
                    }
                }
            });
        }

        function runCountDown() {
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


                $('.product-slider-active').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    pauseOnHover: true,
                    speed: 2000 ,
                    dots: false,
                    arrows: false,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                    responsive: [
                        {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow:1,
                        }
                        },
                        {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 1
                        }
                        },
                        {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                        },
                        {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 1
                        }
                        }
                    ]
                });


            }
        }





    </script>



@endpush
