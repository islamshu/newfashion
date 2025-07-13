@extends('layouts.master')
@section('title', __('إضافة إعلان منبثق'))
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 28px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4CAF50;
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }
</style>
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <!-- العنوان والبريد -->
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إضافة إعلان منبثق') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('إضافة إعلان منبثق') }}</li>
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
                                    <h4 class="card-title">{{ __('تفاصيل الإعلان المنبثق') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('add_general') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="popupStatusSelect">{{ __('حالة الإعلان المنبثق') }}</label>
                                                <select name="general[popup_status]" id="popupStatusSelect"
                                                    class="form-control">
                                                    <option value="1"
                                                        {{ get_general_value('popup_status') == 1 ? 'selected' : '' }}>
                                                        {{ __('مفعل') }}</option>
                                                    <option value="0"
                                                        {{ get_general_value('popup_status') == 0 ? 'selected' : '' }}>
                                                        {{ __('معطل') }}</option>
                                                </select>
                                            </div>



                                            <!-- صورة الإعلان -->
                                            <div class="form-group">
                                                <label>{{ __('صورة الإعلان') }}</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input image-input"
                                                        id="popup_image"name="general_file[popup_image]">
                                                    <label class="custom-file-label"
                                                        for="popup_image">{{ __('اختر ملف') }}</label>
                                                </div>
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . get_general_value('popup_image')) }}"
                                                        style="width: 150px; height: auto;"
                                                        class="img-thumbnail image-preview" alt="">
                                                </div>
                                                @error('popup_image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- لون خلفية الإعلان -->
                                            <div class="form-group">
                                                <label>{{ __('لون خلفية الإعلان') }}</label>
                                                <input type="color" name="general[popup_bg_color]" class="form-control" value="{{ get_general_value('popup_bg_color', '#ffffff') }}">
                                            </div>
                                            <!-- عنوان الإعلان -->
                                            <!-- عنوان الإعلان - العربية -->
                                            <div class="form-group">
                                                <label>عنوان الإعلان بالعربية</label>
                                                <input type="text" name="general[popup_title_ar]" class="form-control"
                                                    placeholder="أدخل عنوان الإعلان بالعربية"
                                                    value="{{ get_general_value('popup_title_ar') }}">
                                            </div>

                                            <!-- عنوان الإعلان - العبرية -->
                                            <div class="form-group">
                                                <label>عنوان الإعلان بالعبرية</label>
                                                <input type="text" name="general[popup_title_he]"
                                                    class="form-control "
                                                    placeholder="أدخل عنوان الإعلان بالعبرية"
                                                    value="{{ get_general_value('popup_title_he') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('رابط الإعلان') }}</label>
                                                <input type="text" name="general[popup_link]" class="form-control"
                                                    placeholder="{{ __('أدخل رابط الإعلان') }}"
                                                    value="{{ get_general_value('popup_link') }}">

                                            </div>
                                            <!-- عنوان الزر - العربية -->
                                            <div class="form-group">
                                                <label>عنوان الزر بالعربية</label>
                                                <input type="text" name="general[popup_button_text_ar]"
                                                    class="form-control" placeholder="أدخل عنوان الزر بالعربية"
                                                    value="{{ get_general_value('popup_button_text_ar') }}">
                                            </div>

                                            <!-- عنوان الزر - العبرية -->
                                            <div class="form-group">
                                                <label>عنوان الزر بالعبرية</label>
                                                <input type="text" name="general[popup_button_text_he]"
                                                    class="form-control "
                                                    placeholder="أدخل عنوان الزر بالعبرية"
                                                    value="{{ get_general_value('popup_button_text_he') }}">
                                            </div>


                                            <!-- رابط الإعلان -->



                                            <!-- زر الحفظ -->
                                            <div class="form-actions text-center mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ الإعلان') }}
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
        $(document).ready(function() {
            // تحديث اسم الملف عند اختياره
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            // عرض صورة المعاينة عند اختيار ملف
            function readURL(input, preview) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(preview).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".image-input").change(function() {
                readURL(this, '.image-preview');
            });
        });
    </script>
@endsection
