@extends('layouts.master')
@section('title', __('تعديل السلايدر') )

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل السلايدر') }}</h3>
                <div class="breadcrumbs-top">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">{{ __('السلايدرات') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('تعديل السلايدر') }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('معلومات السلايدر') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                @foreach(['ar' => 'العربية', 'he' => 'العبرية'] as $locale => $label)
                                    <div class="col-md-6 mt-2">
                                        <label for="title_{{ $locale }}">العنوان ({{ $label }})</label>
                                        <input type="text" name="title[{{ $locale }}]" id="title_{{ $locale }}" class="form-control"
                                               value="{{ old("title.$locale", $slider->getTranslation('title', $locale)) }}">
                                        @error("title.$locale")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="subtitle_{{ $locale }}">العنوان الفرعي ({{ $label }})</label>
                                        <input type="text" name="subtitle[{{ $locale }}]" id="subtitle_{{ $locale }}" class="form-control"
                                               value="{{ old("subtitle.$locale", $slider->getTranslation('subtitle', $locale)) }}">
                                        @error("subtitle.$locale")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="button_text_{{ $locale }}">نص الزر ({{ $label }})</label>
                                        <input type="text" name="button_text[{{ $locale }}]" id="button_text_{{ $locale }}" class="form-control"
                                               value="{{ old("button_text.$locale", $slider->getTranslation('button_text', $locale)) }}">
                                        @error("button_text.$locale")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="button_link">رابط الزر</label>
                                    <input type="text" name="button_link" id="button_link" class="form-control"
                                           value="{{ old('button_link', $slider->button_link) }}">
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

                                    @if($slider->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $slider->image) }}" class="img-thumbnail image-preview" style="width: 120px;" alt="Preview">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">
                                <i class="la la-save"></i> {{ __('تحديث') }}
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
