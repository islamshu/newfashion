@extends('layouts.master')
@section('title', isset($page) ? __('تعديل صفحة') : __('إضافة صفحة'))

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">
                    {{ isset($page) ? __('تعديل صفحة') : __('إضافة صفحة') }}
                </h3>
            </div>
        </div>

        <div class="content-body">
            <section id="page-form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('إدارة الصفحة') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form action="{{ isset($page) ? route('pages.update', $page->id) : route('pages.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @if (isset($page))
                                            @method('PUT')
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title_ar">{{ __('العنوان بالعربية') }}</label>
                                                    <input required type="text" name="title[ar]" id="title_ar"
                                                        class="form-control"
                                                        value="{{ old('title.ar', isset($page) ? $page->getTranslation('title', 'ar') : '') }}">
                                                    @error('title.ar')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title_he">{{ __('العنوان بالعبرية') }}</label>
                                                    <input required type="text" name="title[he]" id="title_he"
                                                        class="form-control" dir="rtl" style="text-align:right"
                                                        value="{{ old('title.he', isset($page) ? $page->getTranslation('title', 'he') : '') }}">
                                                    @error('title.he')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المحتوى بالعربية -->
                                        <div class="form-group">
                                            <label for="content_ar">{{ __('المحتوى بالعربية') }}</label>
                                            <textarea required name="text[ar]" class="form-control tiny-editor"
                                                rows="6">{{ old('text.ar', isset($page) ? $page->getTranslation('text', 'ar') : '') }}</textarea>
                                            @error('text.ar')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- المحتوى بالعبرية -->
                                        <div class="form-group">
                                            <label for="content_he">{{ __('المحتوى بالعبرية') }}</label>
                                            <textarea required name="text[he]" class="form-control tiny-editor" rows="6" dir="rtl"
                                                style="text-align:right">{{ old('text.he', isset($page) ? $page->getTranslation('text', 'he') : '') }}</textarea>
                                            @error('text.he')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

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
