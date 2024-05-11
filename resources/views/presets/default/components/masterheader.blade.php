@php
    $languages = App\Models\Language::all();
@endphp
<div class="row ">
    <div class="col-lg-12">
        <div class="dashboard-header-wrap d-flex justify-content-between">
            <div class="header-left d-flex align-items-center">
                <h3>{{__($pageTitle)}}</h3>
              <button> <i class="las la-bars dashboard-show-hide"></i></button>
            </div>
            <div class="header-right">
                <div class="header-language-wrap d-flex align-items-center">
                    <span class="language-box__icon fs-14"><i class="fas fa-globe"></i>
                    </span>
                    <div class="language-box ms-3">
                        <select class="select langSel">
                            @foreach ($languages as $lang)
                                <option value="{{$lang->code}}" @if(Session::get('lang')==$lang->code) selected @endif> {{__($lang->name)}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="item">
                    <div class="icon">
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
