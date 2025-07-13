@extends('layouts.master')
@section('title', isset($banner) ? __('تعديل بانر') : __('إضافة بانر'))

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">
                    {{ isset($banner) ? __('تعديل بانر') : __('إضافة بانر') }}
                </h3>
            </div>
        </div>

        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($banner) ? route('banners.update', $banner->id) : route('banners.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($banner)) @method('PUT') @endif

                        <div class="row">
                            <!-- صورة البانر -->
                           <div class="form-group col-md-6">
    <label>{{ __('صورة البانر') }}</label>
    <input type="file" name="image" class="form-control" id="imageInput">
    <img id="imagePreview" src="{{ isset($banner) && $banner->image ? asset('storage/' . $banner->image) : '' }}" 
         style="width: 150px; height: auto; margin-top: 10px; display: {{ isset($banner) && $banner->image ? 'block' : 'none' }};" alt="معاينة الصورة">
    @error('image')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const [file] = this.files;
        const preview = document.getElementById('imagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>


                            <!-- الرابط -->
                            <div class="form-group col-md-6">
                                <label>{{ __('رابط الزر') }}</label>
                                <input type="text" name="link" class="form-control"
                                    value="{{ old('link', optional($banner)->link) }}">
                                @error('link')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- محتوى الإعلان بالعربية -->
                            <div class="form-group col-md-12">
                                <label>{{ __('محتوى الإعلان بالعربية') }}</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="title[ar]" class="form-control mb-2"
                                            placeholder="{{ __('عنوان الإعلان بالعربية') }}"
                                            value="{{ old('title.ar', optional($banner)->getTranslation('title', 'ar')) }}">
                                        @error('title.ar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <textarea name="description[ar]" class="form-control mb-2" placeholder="{{ __('وصف الإعلان بالعربية') }}" rows="1">{{ old('description.ar', optional($banner)->getTranslation('description', 'ar')) }}</textarea>
                                        @error('description.ar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="button_text[ar]" class="form-control mb-2"
                                            placeholder="{{ __('عنوان الزر بالعربية') }}"
                                            value="{{ old('button_text.ar', optional($banner)->getTranslation('button_text', 'ar')) }}">
                                        @error('button_text.ar') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- محتوى الإعلان بالعبرية -->
                            <div class="form-group col-md-12">
                                <label>{{ __('محتوى الإعلان بالعبرية') }}</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="title[he]" class="form-control  mb-2" dir="rtl"
                                            placeholder="{{ __('عنوان الإعلان بالعبرية') }}"
                                            value="{{ old('title.he', optional($banner)->getTranslation('title', 'he')) }}">
                                        @error('title.he') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <textarea name="description[he]" class="form-control  mb-2" dir="rtl"
                                            placeholder="{{ __('وصف الإعلان بالعبرية') }}" rows="1">{{ old('description.he', optional($banner)->getTranslation('description', 'he')) }}</textarea>
                                        @error('description.he') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="button_text[he]" class="form-control  mb-2" dir="rtl"
                                            placeholder="{{ __('عنوان الزر بالعبرية') }}"
                                            value="{{ old('button_text.he', optional($banner)->getTranslation('button_text', 'he')) }}">
                                        @error('button_text.he') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($banner) ? __('تحديث') : __('حفظ') }}
                            </button>
                            <a href="{{ route('banners.index') }}" class="btn btn-secondary">{{ __('إلغاء') }}</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
