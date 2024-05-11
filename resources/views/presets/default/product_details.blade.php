@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="product-detials py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="product-details">

                        <div class="product-box">
                            <div class="product-box__thumb">
                                <div class="product-details-slider product-details-active">
                                    @forelse($product->productImages as $image)
                                    <div class="product-single-slider">
                                        <img src="{{ getImage(getFilePath('product') . '/'.@$image->path .'/'.@$image->image)}}" alt="@lang('Auction Product')">
                                    </div>
                                    @empty

                                    @endforelse
                                </div>
                            </div>
                            <div class="product-box__right">
                                <div class="product-box__top">
                                    <h3 class="site-title mb-1">{{__(@$product->title)}} </h3>
                                    @if($product->user)
                                    <div class="rating-list">
                                        @if (ceil($product->user->avg_review) > 0)
                                            <div class="rating-list__item">
                                                @for ($i = 1; $i <= ceil($product->user->avg_review); $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @if (ceil($product->user->avg_review) < 5)
                                                    @for ($i = $product->user->avg_review; $i < 5; $i++)
                                                        <i class="far fa-star"></i>
                                                    @endfor
                                                @endif
                                                <span>({{ formatCount(@$product->user->review_count) }})</span>
                                            </div>
                                        @else
                                        <div class="rating-list__item">
                                            @if (ceil($product->user->avg_review) < 5)
                                                @for ($i = $product->user->avg_review; $i < 5; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            @endif
                                            <span>({{ formatCount(@$product->user->avg_review) }})</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="product-box__content">
                                    <p>{{__($product->short_description)}}</p>
                                </div>
                                <div class="product-box__bottom">
                                    <h4>{{$general->cur_sym}}{{showAmount($product->price,0)}}</h4>

                                        @auth()

                                        @if($product->started_at < now())
                                        <form action="{{route('user.bid')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="input-wrapper">
                                                <input type="number" class="form--control" name="price" step="1" value="{{old('price')}}" placeholder="{{showAmount($product->price, 0)}}" required>
                                                <button class="product-btn">@lang('bid now')</button>
                                            </div>
                                        </form>
                                        @else
                                        <p class="text-danger">@lang('You are only eligible to place bids when the auction has commenced.')</p>
                                        @endif
                                        @else
                                        <a title="@lang('Login')" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#confirmation" class="btn btn--base btn--sm border-none mb-2 confirmation">@lang('Login To Bid')</a>
                                        @endauth

                                </div>
                            </div>
                        </div>

                        <div class="product-details_tab-wrapper">
                            <ul class="custom--tab nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">@lang('Description')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification" type="button" role="tab" aria-controls="specification" aria-selected="false">@lang('Specification')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false"><i class="fas fa-star"></i>@lang('Review')</button>
                                </li>
                            </ul>
                            <div class="tab-content wrapper" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                    <div class="mb-4 wyg">
                                        @php echo trans($product->description) @endphp
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                                    <div class="specification mb-4">
                                        @if($product->specification != null)
                                            @forelse(json_decode($product->specification) as $item)
                                                <div class="specification__item">
                                                    <p>{{@$item->name}}</p>
                                                    <p>{{@$item->value}}</p>
                                                </div>
                                            @empty

                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                    <div class="review-wrap">
                                        <h5 class="details-subtitle mb-4">@lang('Explore Merchant Reviews and Share Your Feedback')</h5>

                                        @php
                                            $reviews = fetchReviews($product->user_id);
                                        @endphp

                                        @forelse($reviews as $review)
                                            <div class="review-wrap">
                                                <div class="review-wrap__top">
                                                    <div class="review-wrap__thumb">
                                                        <img src="{{ getImage(getFilePath('userProfile').'/'.@$review->review->image) }}" alt="@lang('Review')">
                                                    </div>
                                                    <div class="review-wrap__content">
                                                    <h4>{{@$review->review->fullname}}</h4>
                                                    <p>{{showDate(@$review->created_at)}}</p>
                                                    <div class="rating-list">
                                                            <div class="rating-list__item">
                                                                @for ($i = 1; $i <= ceil($review->rating); $i++)
                                                                    <i class="fas fa-star"></i>
                                                                @endfor
                                                                @if (ceil($review->rating) < 5)
                                                                    @for ($i = $review->rating; $i < 5; $i++)
                                                                        <i class="far fa-star"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty

                                        @endforelse

                                        <!-- Comments Form Start -->
                                        @auth()
                                            <div class="contact-form pt-4">

                                                <form action="{{ route('user.review') }}" method="POST">
                                                    @csrf
                                                    <div class="account-form__content mb-4">
                                                        <h3 class="account-form__title mb-2"> @lang('Review Here') </h3>
                                                        <p class="account-form__desc mb-2">@lang('Email not published. Required fields marked.') <span class="text-danger">*</span></p>
                                                        <div class="review-wrap d-flex align-items-center mb-2">
                                                            <p class="stock me-2">@lang('Give Rating'):<span class="text-danger"> *</span></p>
                                                            <ul class="rating-list review-rating justify-content-center d-flex">
                                                                <li class="rating-list__item"><i class="far fa-star" data-rating="1"></i></li>
                                                                <li class="rating-list__item"><i class="far fa-star" data-rating="2"></i></li>
                                                                <li class="rating-list__item"><i class="far fa-star" data-rating="3"></i></li>
                                                                <li class="rating-list__item"><i class="far fa-star" data-rating="4"></i></li>
                                                                <li class="rating-list__item"><i class="far fa-star" data-rating="5"></i></li>
                                                            </ul>

                                                            <input type="hidden" id="rating" name="rating" value="0">
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        </div>

                                                        <div class="row gy-md-4 gy-3">
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form--control" value="{{ auth()->user()->firstname && auth()->user()->lastname ? auth()->user()->firstname . ' ' . auth()->user()->lastname : auth()->user()->username }}" readonly>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="email" class="form--control" value="{{ auth()->user()->email }}" readonly>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <textarea class="form--control" placeholder="@lang('Write Your Feedback')" id="messages" name="message" required></textarea>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <button class="btn btn--base w-100"> @lang('Submit') <span class="button__icon"><i class="fas fa-paper-plane"></i></span></button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </form>
                                            </div>
                                        @else
                                            <div class="mt-4">
                                                <a title="@lang('Login')" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#confirmation" class="btn btn--base border-none mb-2 confirmation">@lang('Login To Review')</a>
                                            </div>
                                        @endauth
                                        <!-- Comment Form End -->

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mt-4">
                                <h4 class=" mb-4">@lang('Related Products')</h4>
                            </div>
                        </div>

                        <div class="row gy-4 justify-content-center related-procuct-slider">

                            @forelse($relatedProducts as $item)
                            <div class="col-lg-6 col-md-6">
                                <div class="single-related-product">
                                    <div class="product">
                                        <div class="product__thumb">
                                            <a href="{{ route('product.details', [slug($item->title),$item->id])}}">
                                                <img src="{{ getImage(getFilePath('product') . '/'.@$item->path .'/'.@$item->image)}}" alt="">
                                            </a>
                                        </div>
                                        <div class="product__top">
                                            <div class="site-title">
                                                <a href="{{ route('product.details', [slug($item->title),$item->id])}}">
                                                    {{__($item->title)}}
                                                </a>
                                            </div>
                                            <span class="product__price">{{$general->cur_sym}} {{showAmount($item->price,0)}}</span>
                                        </div>
                                        <div class="product__body">
                                            <div class="price-item">
                                                <p class="price-title">@lang('HIGHEST BID')</p>
                                                <div class="price">
                                                    <span class="icon"><i class="fas fa-caret-up"></i></span><p>
                                                        {{$general->cur_sym}}{{showAmount(highestBidCount($item->id), 0)}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="price-item">
                                                <p class="price-title">@lang('TOTAL BIDS')</p>
                                                <div class="price">
                                                    <span class="icon"><i class="far fa-user"></i></span><p>{{totalBidCount($item->id)}}</p>
                                                </div>
                                            </div>
                                            @if($item->started_at < now())
                                                <div class="price-item">
                                                    <p class="price-title">@lang('TIME LEFT')</p>
                                                    <div class="price">
                                                        <span class="icon"><i class="far fa-clock"></i></span>

                                                        <p>
                                                            @if($item->expired_at > now())
                                                                <span id="countdown_{{ $item->id }}" class="countdown" data-date="{{ showDateTime(@$item->expired_at, 'm/d/Y H:i:s') }}"></span>
                                                            @else
                                                                <span>@lang('Closed')</span>
                                                            @endif
                                                        </p>

                                                        {{-- @push('script')
                                                        <script>
                                                            $(document).ready(function() {
                                                                "use strict";
                                                                var end = moment('{{ @$item->expired_at }}');
                                                                var now = moment();
                                                                function updateExpiredIn() {
                                                                    var duration = moment.duration(end.diff(now));
                                                                    var days = Math.floor(duration.asDays());
                                                                    var hours = Math.floor(duration.asHours()) - days * 24;
                                                                    var minutes = Math.floor(duration.asMinutes()) - days * 24 * 60 - hours * 60;
                                                                    var seconds = Math.floor(duration.asSeconds()) - days * 24 * 60 * 60 - hours * 60 * 60 - minutes * 60;
                                                                    var expiredIn = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
                                                                    $('#countdown_{{ $item->id }}').text(expiredIn);
                                                                }

                                                                setInterval(function() {
                                                                    now = moment();
                                                                    updateExpiredIn();
                                                                }, 1000);

                                                                updateExpiredIn();
                                                            });
                                                        </script>
                                                        @endpush --}}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price-item">
                                                    <p class="price-title">@lang('START TIME')</p>
                                                    <div class="price">
                                                        <span class="icon"><i class="far fa-clock"></i></span>

                                                        <p>
                                                            <span id="countdown_{{ $item->id }}" class="countdown" data-date="{{ showDateTime(@$item->started_at, 'm/d/Y H:i:s') }}"></span>
                                                        </p>

                                
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product__bottom">
                                            <a href="{{ route('product.details', [slug($item->title),$item->id])}}" class="product-btn">@lang('Details')</a>
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
                            </div>
                            @empty

                            <p class="mb-3">@lang('No related product found')</p>

                            @endforelse

                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- ==================== product Sidebar Start =============== -->
                    <div class="blog-sidebar-wrapper product-sidebar mb-3">
                        <div class="blog-sidebar">
                            <div class="side-bar-item">
                                <div class="product__body">
                                    <div class="price-item">
                                        <p class="price-title">@lang('HIGHEST BID')</p>
                                        <div class="price">
                                            <span class="icon"><i class="fas fa-caret-up"></i></span><p>{{$general->cur_sym}}{{showAmount(highestBidCount($product->id), 0)}}</p>
                                        </div>
                                    </div>
                                    <div class="price-item">
                                        <p class="price-title">@lang('Total BIDs')</p>
                                        <div class="price">
                                            <span class="icon"><i class="fa solid fa-user"></i></span><p>{{totalBidCount($product->id)}}</p>
                                        </div>
                                    </div>

                                    @if($product->started_at < now())
                                        <div class="price-item">
                                            <p class="price-title">@lang('TIME LEFT')</p>
                                            <div class="price">
                                                <span class="icon"><i class="far fa-clock"></i></span>

                                                <p>
                                                    @if($product->expired_at > now())
                                                    <span id="countdown_details_{{ $product->id }}" class="countdown" data-date="{{ showDateTime(@$product->expired_at, 'm/d/Y H:i:s') }}"></span>
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
                                                    <span id="countdown_details_{{ $product->id }}" class="countdown" data-date="{{ showDateTime(@$product->started_at, 'm/d/Y H:i:s') }}"></span>
                                                </p>

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($product->user)
                                <div class="side-bar-item">
                                    <h5 class="blog-sidebar__title">@lang('About Seller') </h5>
                                    <div class="about-seller__wrap">
                                        <div class="author-wrap">
                                            @if($product->user->image)
                                            <div class="author-wrap__thumb">
                                            <img src="{{ getImage(getFilePath('userProfile').'/'.@$product->user->image) }}" alt="">
                                            </div>
                                            @endif
                                            <div class="author-wrap__content">
                                            <h5>{{@$product->user->fullname}}</h5>
                                            <p>@lang('Since')
                                                {{ $product->user->created_at->format('d') }} {{ $product->user->created_at->format('M') }}, {{ $product->user->created_at->format('Y') }}
                                            </p>
                                            </div>
                                        </div>

                                        <div class="about-seller__content">
                                            <p class="mb-4">{{@$product->user->myself}}</p>
                                        </div>

                                        <div class="about-seller__bottom">
                                            <div class="product__body">
                                                <div class="price-item">
                                                    <p class="price-title">@lang('HIGHEST BID')</p>
                                                    <div class="price">
                                                        <span class="icon"></span><p>{{$general->cur_sym}}{{showAmount(sellerHighestBidCount($product->user->id), 0)}}</p>
                                                    </div>
                                                </div>
                                                <div class="price-item">
                                                    <p class="price-title">@lang('Total BIDs')</p>
                                                    <div class="price">
                                                        <span class="icon"><i class="fa solid fa-user"></i></span><p>{{sellerTotalBidCount($product->user->id)}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="side-bar-item">
                                <h5 class="blog-sidebar__title">@lang('Bidder List') </h5>
                                <div class="about-seller__wrap">
                                    <div class="about-seller__bottom">

                                        @forelse($product->bids as $bidder)
                                            <ul class="list-group userData">
                                                <li class="list--group--item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        {{$bidder->bidder->fullname}}
                                                        <br>
                                                        {{ substr($bidder->bidder->email, 0, 2) . '***.com' }}
                                                    </span>
                                                    <span>
                                                        {{$general->cur_sym}}{{showAmount($bidder->price,2)}}
                                                        <br>
                                                        {{showDateTime($bidder->updated_at)}}
                                                    </span>
                                                </li>
                                            </ul>
                                        @empty

                                        <p>@lang('No one bid yet. Be the first bidder') ...</p>

                                        @endforelse

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- ==================== product Sidebar End =============== -->

                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal fade" id="confirmation" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog custom--modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabelLogin">@lang('Login To Your Account')!</h1>
                    <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>

                <form method="POST" action="{{ route('user.modal.login') }}" class="verify-gcaptcha">
                    @csrf
                    <input type="hidden" name="another" value="1">
                    <div class="modal-body">
                        <input type="text" name="username" class="form--control mb-3"  placeholder="@lang('Email or Username')" value="{{old('username')}}" required>

                        <div class="form-group input-group">
                            <input type="password" class="form--control" id="password" name="password" required="" placeholder="@lang('Password')">
                            <div class="password-show-hide fas fa-eye-slash toggle-password-change" data-target="password"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <x-captcha></x-captcha>
                    <button type="reset" class="btn--sm btn btn--base outline" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" id="recaptcha" class="btn btn--sm btn--base border-none">@lang('Login')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Login Modal  -->

@endsection

@push('script')

    <script>
        (function($) {
            "use strict";

                $('.confirmation').on('click', function() {
                    var modal = $('#confirmation');
                    modal.modal('show');
                });

                $('.review-rating i').on('click', function() {
                    var rating = parseInt($(this).data('rating'));
                    $('#rating').val(rating);
                    updateStars(rating);
                });

                $('#rating').on('input', function() {
                    var rating = $(this).val();
                    updateStars(rating);
                });

                function updateStars(rating) {
                    var stars = $('.review-rating i');
                    stars.removeClass('fas').addClass('far');
                    stars.each(function(index) {
                        if (index < rating) {
                            $(this).removeClass('far').addClass('fas');
                        }
                    });
                }

                var initialRating = parseInt($('#rating').val());
                if (initialRating > 0) {
                    updateStars(initialRating);
                }

        })(jQuery);
    </script>
@endpush
