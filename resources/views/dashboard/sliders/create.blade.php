@extends('layouts.master')
@section('title', __('إضافة سلايدر') )

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إضافة سلايدر جديد') }}</h3>
                <div class="breadcrumbs-top">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">{{ __('السلايدرات') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('إضافة سلايدر') }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">{{ __('معلومات السلايدر') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- تبويب اللغات --}}
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="ar-tab" data-toggle="tab" href="#ar" role="tab">العربية</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="he-tab" data-toggle="tab" href="#he" role="tab">עברית</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                {{-- العربية --}}
                                <div class="tab-pane fade show active" id="ar" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label for="title_ar">العنوان</label>
                                            <input type="text" name="title[ar]" id="title_ar" class="form-control" value="{{ old('title.ar') }}">
                                            @error('title.ar')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label for="subtitle_ar">العنوان الفرعي</label>
                                            <input type="text" name="subtitle[ar]" id="subtitle_ar" class="form-control" value="{{ old('subtitle.ar') }}">
                                            @error('subtitle.ar')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label for="button_text_ar">نص الزر</label>
                                            <input type="text" name="button_text[ar]" id="button_text_ar" class="form-control" value="{{ old('button_text.ar') }}">
                                            @error('button_text.ar')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- العبرية --}}
                                <div class="tab-pane fade" id="he" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label for="title_he">הכותרת</label>
                                            <input type="text" name="title[he]" id="title_he" class="form-control" value="{{ old('title.he') }}">
                                            @error('title.he')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label for="subtitle_he">כותרת משנה</label>
                                            <input type="text" name="subtitle[he]" id="subtitle_he" class="form-control" value="{{ old('subtitle.he') }}">
                                            @error('subtitle.he')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label for="button_text_he">טקסט כפתור</label>
                                            <input type="text" name="button_text[he]" id="button_text_he" class="form-control" value="{{ old('button_text.he') }}">
                                            @error('button_text.he')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="button_link">رابط الزر</label>
                                    <input type="text" name="button_link" id="button_link" class="form-control" value="{{ old('button_link') }}">
                                    @error('button_link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="image">الصورة</label>
                                    <input type="file" name="image" id="image" class="form-control image" accept="image/*">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    <div class="mt-2">
                                        <img src="" class="img-thumbnail image-preview" style="width: 120px;" >
                                    </div>
                                </div>
                            </div>

                           

                            <button type="submit" class="btn btn-success mt-4">
                                <i class="la la-save"></i> {{ __('حفظ') }}
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // عرض معاينة فورية للصورة عند اختيارها
    document.querySelector("#image").addEventListener("change", function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                document.querySelector(".image-preview").src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
