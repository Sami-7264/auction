@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="row gy-4 justify-content-center">
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('S.N')</th>
                            <th>@lang('Product Name')</th>
                            <th>@lang('Product Price')</th>
                            <th>@lang('Bid Price')</th>
                            <th>@lang('Bid Time')</th>
                            <th>@lang('View')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($winners as $winner)
                            <tr>
                                <td data-label="S.N">{{ $loop->iteration }}</td>
                                <td data-label="Product Name">{{ @$winner->getProduct->title }}</td>
                                <td data-label="Product Price">{{ showAmount(@$winner->getProduct->price,2) }}</td>
                                <td data-label="Bid Price">{{ showAmount(@$winner->getBid->price, 2) }}</td>
                                <td data-label="Bid Time">
                                    {{ showDateTime($winner->getBid->created_at, 'd M, Y H:s:ia') }}
                                </td>

                                <td data-label="View">
                                    <div class="button--group">
                                        <a title="@lang('Details')" href="javascript:void(0)" class="btn btn--sm btn--base detailsBtn border-none" data-owner="{{ $winner->getProduct->user ? $winner->getProduct->user->fullname : 'Administrator' }}" data-title="{{$winner->getProduct->title}}" data-price="{{ showAmount($winner->getProduct->price,2) }}" data-product="{{$winner->getProduct}}" data-time="{{showDateTime($winner->getBid->created_at, 'd M, Y H:s:ia')}}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if ($winners->hasPages())
                    <div class="text-end py-4">
                        {{ paginateLinks($winners) }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- REJECT MODAL --}}
<div id="biddingDetailsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Product Information')!</h1>
                <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>

                <div class="modal-body">
                    <div class="gig-img-wrap my-3">
                        <img class="gig-img" src="{{ getImage(getFilePath('product') . '/'.@$product->path .'/' .@$product->image)}}" alt="@lang('Product Image')">
                    </div>
                    <div class="list-group-wrap-bidding">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Title')</span>
                                <span><a target="_blank" href="" class="product-title-text"> </a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Owner')</span>
                                <span class="product-owner-text"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Price')</span>
                                <span class="product-price-text"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="reset" class="btn--sm btn btn--base" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection



@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailsBtn').on('click', function () {


            const slugify = str => str
                            .toLowerCase()
                            .trim()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/[\s_-]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                            var websiteUrl = "{{ url('/') }}/";


            var modal = $('#biddingDetailsModal');
            var product = $(this).data('product');
            let slug = slugify(product.title);
            let id = product.id;
            var owner = $(this).data('owner');
            var title = $(this).data('title');
            var price = $(this).data('price');
            modal.find('.product-owner-text').text(owner);
            modal.find('.product-title-text').text(title);

            var href = websiteUrl + 'product/details/' + slug + '/' + id;
            modal.find('.product-title-text').attr('href', href);
            modal.find('.product-price-text').text(price);

            var image = "";

            if (product.image) {
                var imagePath = websiteUrl + "{{ getFilePath('product') }}" +'/' + product.path + '/'  + product.image;
                image = imagePath;
            }

            modal.find('.gig-img').attr('src', image);

            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush




