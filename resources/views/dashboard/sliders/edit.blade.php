@extends('layouts.master')
@section('title', __('تعديل سلايدر') )

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل سلايدر') }}</h3>
                <div class="breadcrumbs-top">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">{{ __('السلايدرات') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('تعديل سلايدر') }}</li>
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

                        <form action="{{ route('sliders.update',$slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                    <div class="col-md-6 mt-2">
                                    <label for="image">الصورة بالعربية</label>
                                    <input type="file"  name="image_ar" id="image_ar" class="form-control image" accept="image/*">
                                    @error('image_ar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    <div class="mt-2">
                                        <img src="{{asset('storage/'.$slider->image_ar)}}" class="img-thumbnail image-preview" style="width: 120px;" >
                                    </div>
                                  
                                </div>
                                 <div class="col-md-6 mt-2">
                                    <label for="image">الصورة بالعبرية</label>
                                    <input type="file"  name="image_he" id="image_ar" class="form-control image" accept="image/*">
                                    @error('image_he')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    <div class="mt-2">
                                        <img src="{{asset('storage/'.$slider->image_he)}}" class="img-thumbnail image-preview" style="width: 120px;" >
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="link">الرابط </label>
                                    <input type="text"  name="link" id="link" class="form-control" value="{{ old('link',$slider->link) }}">
                                    @error('link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
    // ربط الحدث بجميع الحقول ذات الكلاس image
    document.querySelectorAll(".image").forEach(input => {
        input.addEventListener("change", function (e) {
            let file = e.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    // عرض المعاينة فقط أسفل هذا الحقل
                    let preview = e.target.closest('.col-md-6').querySelector('.image-preview');
                    if (preview) {
                        preview.src = event.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection

