@extends('layouts.master')
@section('title', __('صفحة من نحن'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('صفحة من نحن') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('صفحة من نحن') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="about-page">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('إدارة محتوى صفحة من نحن') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('add_general') }}" method="post">
                                            @csrf

                                            <!-- العربية -->
                                            <div class="form-group">
                                                <label for="about_ar">{{ __('الوصف بالعربية') }}</label>
                                                <textarea name="general[about_ar]" class="form-control tiny-editor" rows="6">{{ get_general_value('about_ar') }}</textarea>

                                            </div>

                                            <!-- العبرية -->
                                            <div class="form-group">
                                                <label for="about_he">{{ __('الوصف بالعبرية') }}</label>
                                                <textarea name="general[about_he]" class="form-control tiny-editor" rows="6" dir="rtl" style="text-align:right">{{ get_general_value('about_he') }}</textarea>

                                            </div>

                                            <!-- زر الحفظ -->
                                            <div class="form-actions text-center mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ التغييرات') }}
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
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea.tiny-editor',
            directionality: 'auto',
            language: 'ar',
            height: 400,
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                'textcolor', 'colorpicker', 'emoticons'
            ],
            toolbar: 'undo redo | styleselect | fontselect fontsizeselect | ' +
                     'bold italic underline strikethrough | forecolor backcolor | ' +
                     'alignleft aligncenter alignright alignjustify | ' +
                     'bullist numlist outdent indent | link image media table emoticons | ' +
                     'code fullscreen preview',
            menubar: 'file edit view insert format tools table help',
            content_style: 'body { font-family:Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection



