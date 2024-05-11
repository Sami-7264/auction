@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="login-area py-60" >
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wyg">
                        <div class="privacy-bg-effect">
                            <div class="banner-right"></div>
                        </div>
                        <div class="privacy-bg-effect left">
                            <div class="banner-effect"></div>
                        </div>
                        @php
                                echo $policy->data_values->details
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@push('style')
<style>
    .wyg ul{
        margin-bottom: 20px;
    }
</style>
@endpush


