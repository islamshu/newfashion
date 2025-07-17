@extends('layouts.master')
@section('title', __('إعداداتصفحة تتبع الطلب'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <!-- العنوان والبريد -->
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إعداداتصفحة تتبع الطلب') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('إعداداتصفحة تتبع الطلب') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جسم الصفحة -->
            <div class="content-body">
                <section id="popup-ad-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('صفحة تتبع الطلب') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('add_general') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf




                                           <!-- صورة الخلفية لصفحة تتبع الطلب -->
<div class="form-group">
    <label>{{ __('الخلفية في صفحة الخاصة للتتبع الطلب') }}</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input image-input"
            id="track_image_cover"
            name="general_file[track_image_cover]"
            data-preview="#preview-track_image_cover">
        <label class="custom-file-label" for="track_image_cover">{{ __('اختر ملف') }}</label>
    </div>
    <div class="mt-2">
        <img id="preview-track_image_cover"
            src="{{ asset('storage/' . get_general_value('track_image_cover')) }}"
            style="width: 150px; height: auto;"
            class="img-thumbnail" alt="">
    </div>
</div>

<!-- صورة الخلفية للصفحة الرئيسية لتتبع الطلب -->
<div class="form-group">
    <label>{{ __('الخلفية في صفحة الخاصة الرئيسية للتبع الطلب') }}</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input image-input"
            id="track_image"
            name="general_file[track_image]"
            data-preview="#preview-track_image">
        <label class="custom-file-label" for="track_image">{{ __('اختر ملف') }}</label>
    </div>
    <div class="mt-2">
        <img id="preview-track_image"
            src="{{ asset('storage/' . get_general_value('track_image')) }}"
            style="width: 150px; height: auto;"
            class="img-thumbnail" alt="">
    </div>
</div>



                                            <!-- زر الحفظ -->
                                            <div class="form-actions text-center mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ') }}
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
   <script>
    $(document).ready(function () {
        // تحديث اسم الملف في العنصر label
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // عرض المعاينة بناءً على data-preview الخاص بكل input
        $('.image-input').on('change', function () {
            const input = this;
            const target = $(this).data('preview');
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(target).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>

@endsection
