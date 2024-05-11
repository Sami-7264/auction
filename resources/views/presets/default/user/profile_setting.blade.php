@extends($activeTemplate.'layouts.master')
@section('content')



<div class="row gy-4 justify-content-center">
    <div class="col-xl-5 col-lg-5">
       <div class="profile-left">
            <div class="dashboard_profile_wrap">
                <div class="profile_photo mt-3">
                    <img src="{{ getImage(getFilePath('userProfile').'/'.auth()->user()->image,getFileSize('userProfile')) }}" alt="@lang('User\'s prifile picture')">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="photo_upload">
                            <label for="file_upload"><i class="fas fa-image"></i></label>
                            <input id="file_upload" name="image" type="file" class="upload_file" onchange="this.form.submit()" accept=".png, .jpeg, .jpg">
                        </div>
                    </form>
                </div>
                <h3>{{ strtolower($user->email) }}</h3>
                <p>{{ '@'.$user->username }}</p>
            </div>
        <div class="profile-left__contact">
            <div class="action-category-item">
                <div class="action-category-item__icon">
                    <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="54" height="49" viewBox="0 0 62 56" fill="none">
                        <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                        </svg>
                        <i class="las la-phone-volume"></i>
                </div>
                <div class="action-category-item__text">
                    <h4 class="site-title"><a href="tel:{{$user->mobile}}">{{$user->mobile}}</a></h4>
                </div>
            </div>
            <div class="action-category-item">
                <div class="action-category-item__icon">
                    <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="54" height="49" viewBox="0 0 62 56" fill="none">
                        <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                        </svg>
                        <i class="las la-envelope"></i>
                </div>
                <div class="action-category-item__text">
                    <h4 class="site-title"><a href="mailto:{{$user->email}}">{{$user->email}}</a></h4>
                </div>
            </div>
            <div class="action-category-item">
                <div class="action-category-item__icon">
                    <svg class="svg-color" xmlns="http://www.w3.org/2000/svg" width="54" height="49" viewBox="0 0 62 56" fill="none">
                        <path d="M60.558 22.6734L60.1261 22.9253C61.958 26.0657 61.958 29.9343 60.1261 33.0746L50.0076 50.4215C48.1755 53.5625 44.7875 55.5 41.1184 55.5H20.8815C17.2123 55.5 13.8245 53.5625 11.9923 50.4215L1.87387 33.0746L1.44198 33.3266L1.87387 33.0746C0.0420438 29.9343 0.0420438 26.0657 1.87387 22.9253L1.44198 22.6734L1.87387 22.9253L11.9922 5.57851C13.8244 2.43753 17.2123 0.5 20.8815 0.5H41.1184C44.7875 0.5 48.1755 2.43753 50.0076 5.57851L60.1261 22.9253L60.558 22.6734Z"></path>
                        </svg>
                        <i class="las la-map-marker"></i>
                </div>
                <div class="action-category-item__text">
                    <h4 class="site-title"><a href="javascript:void(0)">{{@$user->address->address}}</a></h4>
                </div>
            </div>
        </div>
       </div>
    </div>
    <div class="col-xl-7 col-lg-7">
        <div class="profile-right-wrap">
            <div class="row gy-3">
                <div class="col-sm-12">
                    <div class="profile-right">
                        <h5>@lang('Update Profile')</h5>
                    </div>
                </div>
            </div>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="firstname" class="form--label">@lang('First Name')</label>
                            <input type="text" class="form--control" id="firstname" name="firstname" value="{{$user->firstname}}" placeholder="@lang('First Name')" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="lastname" class="form--label">@lang('Last Name')</label>
                            <input type="text" class="form--control" id="lastname" name="lastname" value="{{$user->lastname}}" required placeholder="@lang('Last Name')">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="username" class="form--label">@lang('Username')</label>
                            <input type="text" class="form--control" id="username" value="{{$user->username}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="email" class="form--label">@lang('Email')</label>
                            <input type="email" class="form--control" id="email" value="{{$user->email}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="state" class="form--label">@lang('State')</label>
                            <input type="text" class="form--control" id="state" placeholder="@lang('State')" name="state" value="{{@$user->address->state}}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="city" class="form--label">@lang('City')</label>
                            <input type="text" class="form--control" id="city" placeholder="@lang('City')" name="city" value="{{@$user->address->city}}">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="zip" class="form--label">@lang('Zip')</label>
                            <input type="text" class="form--control" id="zip" name="zip" value="{{@$user->address->zip}}" placeholder="@lang('Zip Code')">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label for="country" class="form--label">@lang('Country')</label>
                                <input type="text" id="country" class="form--control" value="{{@$user->address->country}}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label for="myself" class="form--label">@lang('Describe Yourself')</label>
                                <textarea class="form--control trumEdit wyg" id="myself" name="myself" placeholder="@lang('Describe yourself')">{{@$user->myself}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 mt-4">
                        <button type="submit" class="btn btn--base border-none w-100">
                            @lang('Update Profile')
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
