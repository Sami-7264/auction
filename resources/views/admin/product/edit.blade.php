@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row gy-4 mb-none-15">
                            <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Title')</label>
                                    <input type="text" class="form-control" placeholder="@lang('Product Title')" name="title" value="{{ $product->title, old('title') }}" required/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Category')</label>
                                    <select name="category" class="form-control" required>
                                        <option value="">@lang('Select One')</option>
                                        @foreach ($categories as $category)
                                            <option {{$product->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                <label class="w-100 font-weight-bold">@lang('Price') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"  name="price" value="{{ intval($product->price) }}" required/>
                            </div>
                            <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                <div class="input-group">
                                    <label class="w-100 font-weight-bold">@lang('Schedule') <span class="text-danger">*</span></label>
                                    <select name="schedule" class="form-control" required>
                                        <option {{ $product->started_at > now() ? 'selected' : '' }} value="1">@lang('Yes')</option>
                                        <option {{ $product->started_at < now() ? 'selected' : '' }} value="0">@lang('No')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-4 col-lg-6 mb-15 started_at">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Started Time')</label>
                                    <input type="text" name="started_at" placeholder="@lang('Select Date & Time')" id="startDateTime" data-position="bottom left" class="form-control border-radius-5" value="{{ $product->started_at }}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-4 col-lg-6 mb-15">
                                <div class="form-group">
                                    <label class="w-100 font-weight-bold">@lang('Expired Time')</label>
                                    <input type="text" name="expired_at" placeholder="@lang('Select Date & Time')" id="endDateTime" data-position="bottom left" class="form-control border-radius-5" value="{{ $product->expired_at }}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Short Description')</label>
                                    <textarea rows="4" class="form-control border-radius-5" name="short_description">{{ $product->short_description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-3">
                                    <label class="font-weight-bold">@lang('Description')</label>
                                    <textarea rows="8" class="form-control trumEdit" name="description">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <div class="price-input-section">
                                    <div class="row mb-3 gy-3">
                                        <div class="col-lg-11 col-mb-10">
                                            <h5 class="font-weight-bold">@lang('Auctions Specification')</h5>
                                        </div>

                                        <div class="col-lg-1 col-md-2 text-end">
                                            <button type="button" class="btn btn--primary btn-block extra_service">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="row extraService">
                                        @php
                                            $specifications = json_decode($product->specification, true);
                                        @endphp
                                        @forelse($specifications as $specification)
                                        <div class="data-extra-service">
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <input class="form-control" name="specification[{{$loop->index}}][name]" type="text" required value="{{$specification['name']}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <input class="form-control" name="specification[{{$loop->index}}][value]" type="text" required value="{{$specification['value']}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1 text-end">
                                                    <button type="button" class="btn btn--primary remove_extra_service"><i class="la la-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">@lang('Add auction Image')</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="photo_upload">
                                    <div class="drag_area" id="dragArea">
                                        <div class="drag_drop_content">
                                            <span title="@lang('Click to add Image')" class="icon_wrap" role="button" id="selectFiles"><i class="las la-file-image"></i></span>
                                            {{-- <p role="button" id="selectFiles">@lang('Click to add Image')</p> --}}
                                        </div>
                                        <input name="images[]" type="file" class="file" multiple id="fileInput" accept=".jpg, .png, .jpeg" required/>
                                    </div>
                                    <div class="container_area" id="containerArea">
                                        @if($product->productImages)
                                        @forelse($product->productImages as $image)
                                            <div class="image">
                                                <span class="delete imageRemove" data-id="{{$image->id}}"><i class="las la-times" href="javascript:void(0)"></i></span>
                                                <img src="{{getImage(getFilePath('product').'/'.@$image->path.'/'.@$image->image) }}" alt="@lang('Boat Image')">
                                            </div>
                                        @empty

                                        @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





{{-- Edit Model Start --}}
<div class="modal fade" id="imageRemoveBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Image Delete Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.product.delete') }}" method="post">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this image?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Model End --}}


@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush


@push('style-lib')
<link rel="stylesheet" href="{{asset('assets/admin/css/datepicker.min.css')}}">
@endpush


@push('script-lib')
<script src="{{ asset('assets/admin/js/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>

        (function ($) {
            "use strict";

            var images = [];
                function selectFiles() {
                    $("#fileInput").click();
                }

                function onFileSelect(event) {
                    const files = event.target.files;
                    if (files.length === 0) return;
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].type.split('/')[0] !== 'image') continue;
                        if (!images.some((e) => e.name == files[i].name)) {
                            images.push({
                                name: files[i].name,
                                url: URL.createObjectURL(files[i])
                            });
                        }
                    }
                    updateImages();
                }

                function deleteImage(index) {
                    images.splice(index, 1);
                    updateImages();
                }

                function updateImages() {
                    images.forEach(function (image, index) {
                        var deleteButton = $('<span class="delete"><i class="las la-times"></i></span>');
                        deleteButton.on("click", function () {
                            deleteImage(index);
                        });
                        var imageDiv = $('<div class="image"></div>').append(deleteButton).append($('<img src="' + image.url + '" alt="..."/>'));
                        $("#containerArea").append(imageDiv);
                    });
                }


                $("#selectFiles").click(selectFiles);
                $("#fileInput").change(onFileSelect);


            var start = new Date(), prevDay, startHours = 0;

            start.setHours(0);
            start.setMinutes(0);

            if ([6, 0].indexOf(start.getDay()) != -1) {
                start.setHours(10);
                startHours = 10
            }

            $('#startDateTime').datepicker({
                timepicker: true,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                startDate: start,
                minHours: startHours,
                maxHours: 23,
                onSelect: function (fd, d, picker) {
                    if (!d) return;

                    var day = d.getDay();

                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    } else {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    }
                }
            });

            $('#endDateTime').datepicker({
                timepicker: true,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                startDate: start,
                minHours: startHours,
                maxHours: 23,
                onSelect: function (fd, d, picker) {

                    if (!d) return;

                    var day = d.getDay();

                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    } else {
                        picker.update({
                            minHours: 0,
                            maxHours: 23
                        })
                    }
                }
            });

            $('#startDateTime').datepicker().data('datepicker').selectDate(new Date('{{ $product->started_at }}'));
            $('#endDateTime').datepicker().data('datepicker').selectDate(new Date('{{ $product->expired_at }}'));


            $("[name=schedule]").on('change', function(e){
                var schedule = e.target.value;

                if(schedule != 1){
                    $("[name=started_at]").attr('disabled', true);
                    $('.started_at').css('display', 'none');
                }else{
                    $("[name=started_at]").attr('disabled', false);
                    $('.started_at').css('display', 'block');
                }
            }).change();


            $('.extra_service').on('click', function () {
            var index = $('.data-extra-service').length;
            var html = `
                <div class="data-extra-service">
                    <div class="row">
                        <div class="col-11">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input class="form-control" name="specification[${index}][name]" type="text" required placeholder="@lang('Name')">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input class="form-control" name="specification[${index}][value]" type="text" required placeholder="@lang('Value')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 text-end">
                            <button type="button" class="btn btn--primary remove_extra_service"><i class="la la-times"></i></button>
                        </div>
                    </div>
                </div>
                `;
            $('.extraService').append(html);
        });

        $(document).on('click', '.remove_extra_service', function () {
            $(this).closest('.data-extra-service').remove();
        });

        $('.imageRemove').on('click', function () {
            var modal = $('#imageRemoveBy');
            modal.find('input[name=id]').val($(this).data('id'))
            console.log($(this).data('id'));
            modal.modal('show');
        });


        })(jQuery);
    </script>
@endpush
