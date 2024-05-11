<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class=" search-boarder border-radious-5 mb-2">
            <p>@lang('Showing Results'): {{ @$products->count() }}</p>
        </div>
    </div>



    @forelse($products as $product)
        <div class="col-lg-6 col-md-6">
            <div class="product">
                <div class="product__thumb">
                    <a href="{{ route('product.details', [slug($product->title), $product->id]) }}">
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
                        <a
                            href="{{ route('product.details', [slug($product->title), $product->id]) }}">{{ __(@$product->title) }}</a>
                    </div>
                    <span class="product__price">{{ $general->cur_sym }} {{ showAmount($product->price, 0) }}</span>
                </div>
                <div class="product__body">
                    <div class="price-item">
                        <p class="price-title">@lang('HIGHEST BID')</p>
                        <div class="price">
                            <span class="icon"><i class="fas fa-caret-up"></i></span>
                            <p>
                                {{ $general->cur_sym }}{{ showAmount(highestBidCount($product->id), 0) }}
                            </p>
                        </div>
                    </div>
                    <div class="price-item">
                        <p class="price-title">@lang('TOTAL BIDS')</p>
                        <div class="price">
                            <span class="icon"><i class="far fa-user"></i></span>
                            <p>{{ totalBidCount($product->id) }}</p>
                        </div>
                    </div>
                    @if ($product->started_at < now())
                        <div class="price-item">
                            <p class="price-title">@lang('TIME LEFT')</p>
                            <div class="price">
                                <span class="icon"><i class="far fa-clock"></i></span>

                                <p>
                                    @if ($product->expired_at > now())
                                        <span id="countdown_render_left_{{ $product->id }}" class="countdown"
                                            data-date="{{ showDateTime(@$product->expired_at, 'm/d/Y H:i:s') }}"></span>
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
                                    <span id="countdown_render_{{ $product->id }}" class="countdown"
                                        data-date="{{ showDateTime(@$product->started_at, 'm/d/Y H:i:s') }}"></span>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="product__bottom">
                    <a href="{{ route('product.details', [slug($product->title), $product->id]) }}">
                        <button class="product-btn">@lang('Details')</button>
                    </a>
                    @auth()
                        @if ($product->getWishlist)
                            @if ($product->getWishlist->user_id == auth()->user()->id && $product->id == $product->getWishlist->product_id)
                                <a href="javascript:void(0)" data-product_id="{{ $product->id }}"
                                    class="love-icon  wishlist-btn"><i class="fas fa-heart"></i></a>
                            @else
                                <a href="javascript:void(0)" data-product_id="{{ $product->id }}"
                                    class="love-icon  wishlist-btn"><i class="far fa-heart"></i></a>
                            @endif
                        @else
                            <a href="javascript:void(0)" data-product_id="{{ $product->id }}"
                                class="love-icon  wishlist-btn"><i class="far fa-heart"></i></a>
                        @endif
                    @else
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#login-upcomming-bid"
                            class="login-upcomming-bid love-icon"><i class="far fa-heart"></i></a>
                    @endauth
                </div>
            </div>
        </div>
    @empty

    @endforelse

</div>




