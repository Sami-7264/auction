@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="row gy-4 justify-content-center dashboard-item-wrap">
                {{-- <div class="action-category-wrapper"> --}}
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-dollar-sign"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ $general->cur_sym }}{{ showAmount($user->balance, 2) }}</h4>
                                <p>@lang('Current Balance')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62"
                                    height="56" viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-wallet"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ $general->cur_sym }}{{ showAmount($totalDeposit, 2) }}</h4>
                                <p>@lang('Total Deposit')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-money-check-alt"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ $general->cur_sym }}{{ showAmount($totalTransaction, 2) }}</h4>
                                <p>@lang('Total transaction')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-ticket-alt"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ @$supportTicketCount }}</h4>
                                <p>@lang('Total Tickets')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-gavel"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ @$bid['total_bid'] }}</h4>
                                <p>@lang('Total Bid')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-money-bill-alt"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ $general->cur_sym }}{{ showAmount($bid['total_bid_pirce'], 2) }}</h4>
                                <p>@lang('Total Bid Amount')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-trophy"></i>

                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ @$winProduct }}</h4>
                                <p>@lang('Win Product')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="action-category-item">
                            <div class="action-category-item__icon">
                                <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                    viewBox="0 0 62 56" fill="none">
                                    <path
                                        d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                    </path>
                                </svg>
                                <i class="las la-exclamation-triangle"></i>
                            </div>
                            <div class="action-category-item__text">
                                <h4 class="site-title">{{ @$bid['total_bid'] - @$winProduct }}</h4>
                                <p>@lang('Total Loose Bid')</p>
                            </div>
                        </div>
                    </div>



                    {{-- Merchant Option Start--}}


                    @if(auth()->user()->kv == 1)

                    {{-- <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="lab la-product-hunt"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{$product['total']}}</h4>
                            <p>@lang('Total Product')</p>
                        </div>
                    </div>

                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="lab la-creative-commons-pd-alt"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{$product['pending']}}</h4>
                            <p>@lang('Pending Product')</p>
                        </div>
                    </div>

                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="lab la-discord"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{$product['live']}}</h4>
                            <p>@lang('Live Product')</p>
                        </div>
                    </div>

                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="lab la-creative-commons-nc-jp"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{$product['cancel']}}</h4>
                            <p>@lang('Cancel Product')</p>
                        </div>
                    </div>

                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-money-check"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{ $general->cur_sym }}{{showAmount($withdraw['total'],2)}}</h4>
                            <p>@lang('Total Withdraw')</p>
                        </div>
                    </div>
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-money-bill-wave"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{ $general->cur_sym }}{{showAmount($withdraw['pending'],2)}}</h4>
                            <p>@lang('Pending Withdraw')</p>
                        </div>
                    </div>
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-money-check-alt"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{ $general->cur_sym }}{{showAmount($withdraw['cancel'],2)}}</h4>
                            <p>@lang('Cancel Withdraw')</p>
                        </div>
                    </div>
                    <div class="action-category-item">
                        <div class="action-category-item__icon">
                            <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="62" height="56"
                                viewBox="0 0 62 56" fill="none">
                                <path
                                    d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z">
                                </path>
                            </svg>
                            <i class="las la-money-check-alt"></i>
                        </div>
                        <div class="action-category-item__text">
                            <h4 class="site-title">{{$product['auction_complete']}}</h4>
                            <p>@lang('Auction Conclusion')</p>
                        </div>
                    </div> --}}

                    @endif
                    {{-- Merchant Option End --}}
                {{-- </div> --}}
            </div>



            <div class="apex-container-wrap">

                <div class="row gy-4 mt-4">
                        <div class="col-lg-6">
                            <div class="apexcharts-wrap">
                                <h5 class="card-title">@lang('Monthly Deposit & Bids Report') (@lang('This year'))</h5>
                                <div id="account-chart"></div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="pie-apex-chart-wrapper apexcharts-wrap">
                                <div>
                                  <div class="chart-wrap">
                                    <h5 class="card-title">@lang('Bid Reports') (@lang('This year'))</h5>
                                    <div id="login-chart"></div>
                                  </div>
                                </div>

                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>






@endsection

@push('script')

<script src="{{asset('assets/admin/js/apexcharts.min.js')}}"></script>

<script>
    // [ account-chart ] start
    (function () {
        "use strict";
        var options = {
            chart: {
                type: 'area',
                stacked: false,
                height: '310px'
            },
            stroke: {
                width: [0, 3],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            colors: ['#00adad', '#67BAA7'],
            series: [{
                name: '@lang("Bids")',
                type: 'column',
                data: @json($bidChart['values'])
            }, {
                name: '@lang("Deposits")',
                type: 'area',
                data: @json($depositsChart['values'])
            }],
            fill: {
                opacity: [0.85, 1],
                        },
            labels: @json($depositsChart['labels']),
            markers: {
                size: 0
            },
            xaxis: {
                type: 'text'
            },
            yaxis: {
                min: 0
            },
            tooltip: {
                shared: true,
                    intersect: false,
                        y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return "$ " + y.toFixed(0);
                        }
                        return y;

                    }
                }
            },
            legend: {
                labels: {
                    useSeriesColors: true
                },
                markers: {
                    customHTML: [
                        function () {
                            return ''
                        },
                        function () {
                            return ''
                        }
                    ]
                }
            }
                    }
            var chart = new ApexCharts(
                document.querySelector("#account-chart"),
                options
            );
            chart.render();
        }) ();

    // [ Bidding Details ] start


    (function () {
        "use strict";
    // Donut chart
    var options = {
      series: [{{$bid['total_bid']}}, {{$winProduct}}, {{$bid['total_bid'] - $winProduct}}],
      labels: ['Total Bid', 'Total Win', 'Total Loose'],
      chart: {
      width: 450,
      type: 'donut',
    },
    dataLabels: {
      enabled: true
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          show: false
        }
      }
    }],
    legend: {
      position: 'right',
      offsetY: 0,
      height: 430,
    }
    };

    var pi_chart = new ApexCharts(document.querySelector("#login-chart"), options);
    pi_chart.render();


    function appendData() {
    var arr = pi_chart.w.globals.series.slice()
    arr.push(Math.floor(Math.random() * (100 - 1 + 1)) + 1)
    return arr;
  }

  function removeData() {
    var arr = chart.w.globals.series.slice()
    arr.pop()
    return arr;
  }

  function randomize() {
    return pi_chart.w.globals.series.map(function() {
        return Math.floor(Math.random() * (100 - 1 + 1)) + 1
    })
  }

  function reset() {
    return options.series
  }
})();

</script>


@endpush
