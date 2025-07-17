@extends('layouts.master')
@section('title', isset($review) ? __('تعديل تقييم') : __('إضافة تقييم'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3>{{ isset($review) ? __('تعديل تقييم') : __('إضافة تقييم') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ isset($review) ? route('reviews.update', $review->id) : route('reviews.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($review))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- الاسم -->
                                <div class="form-group col-md-6">
                                    <label>{{ __('اسم المقيم') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $review->name ?? '') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- الوظيفة -->


                                <!-- عدد النجوم -->
                                <div class="form-group col-md-6">
                                    <label>{{ __('عدد النجوم') }}</label>
                                    <input type="number" name="stars" min="1" max="5" class="form-control"
                                        value="{{ old('stars', $review->stars ?? 5) }}">
                                    @error('stars')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- الصورة -->
                                <div class="form-group col-md-6">
                                    <label>{{ __('الصورة') }}</label>
                                    <input type="file" name="image" class="form-control" id="imageInput">
                                    <img id="imagePreview"
                                        src="{{ isset($review) && $review->image ? asset('storage/' . $review->image) : '' }}"
                                        style="width: 120px; height: auto; margin-top: 10px; display: {{ isset($review) && $review->image ? 'block' : 'none' }};"
                                        alt="معاينة الصورة">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">


                                <div class="form-group col-md-6">
                                    <label>{{ __('الوظيفة بالعربية') }}</label>
                                    <input type="text" name="job[ar]" class="form-control"
                                        value="{{ old('job.ar', isset($review) ? $review->getTranslation('job', 'ar') : '') }}">
                                    @error('job.ar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- الوظيفة بالعبرية -->
                                <div class="form-group col-md-6">
                                    <label>{{ __('الوظيفة بالعبرية') }}</label>
                                    <input type="text" name="job[he]" class="form-control" dir="rtl"
                                        value="{{ old('job.he', isset($review) ? $review->getTranslation('job', 'he') : '') }}">
                                    @error('job.he')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- الوصف بالعربية -->
                                <div class="form-group col-md-12">
                                    <label>{{ __('الوصف بالعربية') }}</label>
                                    <textarea name="description[ar]" class="tiny-editor form-control">{{ old('description.ar', isset($review) ? $review->getTranslation('description', 'ar') : '') }}</textarea>
                                    @error('description.ar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- الوصف بالعبرية -->
                                <div class="form-group col-md-12">
                                    <label>{{ __('الوصف بالعبرية') }}</label>
                                    <textarea name="description[he]" class="tiny-editor form-control" dir="rtl">{{ old('description.he', isset($review) ? $review->getTranslation('description', 'he') : '') }}</textarea>
                                    @error('description.he')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- الوظيفة بالعربية -->



                            </div>

                            <button type="submit"
                                class="btn btn-primary">{{ isset($review) ? __('تحديث') : __('حفظ') }}</button>
                            <a href="{{ route('reviews.index') }}" class="btn btn-secondary">{{ __('إلغاء') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
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
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    {{-- <script>
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
    </script> --}}

@endsection
