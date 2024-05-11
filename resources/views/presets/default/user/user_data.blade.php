@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="account position-relative py-120">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-7 col-xl-7 col-md-9">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> {{ __($pageTitle) }} </h3>
                        </div>

                            <form method="POST" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('First Name')</label>
                                        <input type="text" class="form--control" name="firstname"
                                            value="{{ old('firstname') }}" required>
                                    </div>

                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('Last Name')</label>
                                        <input type="text" class="form--control" name="lastname"
                                            value="{{ old('lastname') }}" required>
                                    </div>

                                    <div class="col-sm-12 mb-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label class="form--label">@lang('Country')</label>
                                                <select name="country" class="select form--control">
                                                    @foreach($countries as $key => $country)
                                                        <option data-mobile_code="{{ $country->dial_code }}" {{ @$user->address->country == $country->country ? 'selected' : ''}} value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                                    @endforeach
                                                </select>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <div class="input-group ">
                                            <label class="form--label">@lang('Mobile')</label>
                                            <div class="input-group country-code">
                                                <span class="input-group-text mobile-code" id="basic-addon1"></span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile', @$user->mobile) }}" class="form--control left-y-radius checkUser" required aria-describedby="basic-addon1">
                                            </div>
                                            <small class="text-danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('Address')</label>
                                        <input type="text" class="form--control" name="address"
                                            value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('State')</label>
                                        <input type="text" class="form--control" name="state"
                                            value="{{ old('state') }}">
                                    </div>
                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('Zip Code')</label>
                                        <input type="text" class="form--control" name="zip"
                                            value="{{ old('zip') }}">
                                    </div>

                                    <div class="form-group col-sm-6 mb-2">
                                        <label class="form--label">@lang('City')</label>
                                        <input type="text" class="form--control" name="city"
                                            value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn--base w-100">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
              <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <i class="las la-times"></i>
              </span>
            </div>
            <div class="modal-body">
              <h6 class="text-center">@lang('You already have an account please Login ')</h6>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-dark two" data-bs-dismiss="modal">@lang('Close')</button>
              <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
            </div>
          </div>
        </div>
      </div>
</section>

@endsection

@push('script')
    <script>
      "use strict";
        (function ($) {
            @if($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout',function(e){
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token};
                 
                }
                $.post(url,data,function(response) {
                    console.log(response.type + " " + response.data);
                    if(response.data != false && response.type == 'mobile'){
                        $('.mobileExist').text(`Mobile number already exist`);
                        // $(`.${response.type}Exist`).text(`${response.type.charAt(0).toUpperCase()}${response.type.slice(1)} already exist`);
                    }else{
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);

    </script>
@endpush
