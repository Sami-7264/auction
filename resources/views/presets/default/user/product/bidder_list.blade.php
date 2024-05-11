@extends($activeTemplate.'layouts.master')

@section('content')


    <div class="row gy-4 justify-content-center">
        <div class="col-lg-12 pb-30">
            <div class="dark-to-light-table">
                <table class="table table--responsive--lg table-boarder">
                    <thead>
                        <tr>
                            <th>@lang('S.N')</th>
                            <th>@lang('Bidder')</th>
                            <th>@lang('Title')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Bid Time')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bids as $bid)
                            <tr>
                                <td data-label="S.N">{{ $loop->iteration }}</td>
                                <td data-label="Bidder">{{ @$bid->bidder->fullname }}</td>
                                <td data-label="Title">{{ @$bid->product->title }}</td>
                                <td data-label="Price">{{ showAmount(@$bid->price, 2) }}</td>
                                <td data-label="Bid Time">
                                    {{ showDateTime($bid->created_at, 'd M, Y H:s:ia') }}
                                </td>

                                <td data-label="Action">
                                    <div class="button--group">
                                        <a title="@lang('Details')" href="javascript:void(0)" class="btn btn--sm btn--base detailsBtn border-none" data-bidder="{{ $bid->bidder->fullname }}" data-price="{{ $bid->price }}" data-time="{{showDateTime($bid->created_at, 'd M, Y H:s:ia')}}">
                                            <i class="las la-desktop"></i>
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
            <div class="row">
                <div class="col-lg-12">
                    @if ($bids->hasPages())
                        <div class="text-end py-4">
                            {{ paginateLinks($bids) }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>







    {{-- REJECT MODAL --}}
<div id="biddingDetailsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog custom--modal">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Bidding Information')!</h1>
                <button type="button" class="btn--close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>

                <div class="modal-body">
                    <img class="gig-img my-3"  width="100%" height="200px" src="{{ getImage(getFilePath('product') . '/'.@$product->path .'/' .@$product->image)}}" alt="@lang('Product Image')">

                    <h6 class="card-title">@lang('Product Information')</h6>
                    <div class="list-group-wrap-bidding">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Name')</span>
                                <span><a target="_blank" href="{{ route('product.details', [slug($product->title),$product->id])}}"> {{ __($product->title) }}</a></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Price')</span>
                                <span>{{showAmount($product->price, 0)}}</span>
                            </li>
                        </ul>
                    </div>
                    <h6 class="card-title">@lang('Bidder Information')</h6>
                    <div class="list-group-wrap-bidding">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Bidder')</span>
                                <span class="bidder-bidder"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Price')</span>
                                <span class="bidding-price"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>@lang('Time')</span>
                                <span class="bidding-time">{{showAmount($product->price, 0)}}</span>
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
            var modal = $('#biddingDetailsModal');
            modal.find('.bidding-price').text($(this).data('price'));
            modal.find('.bidding-time').text($(this).data('time'));
            modal.find('.bidder-bidder').text($(this).data('bidder'));
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush




