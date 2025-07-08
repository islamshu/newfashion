@extends('layouts.master')
@section('title', __('إضافة تصنيف جديد'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إضافة تصنيف جديد') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('categories.index') }}">{{ __('التصنيفات') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('إضافة تصنيف جديد') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('بيانات التصنيف') }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body pt-0">
                                        @include('dashboard.inc.alerts')

                                        <form class="form" action="{{ route('categories.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <!-- الإعدادات العامة -->
                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title">
                                                    <i class="ft-settings"></i> {{ __('الإعدادات العامة') }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('الحالة') }}</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="1" selected>{{ __('مفعل') }}
                                                                </option>
                                                                <option value="0">{{ __('غير مفعل') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="parent_id">{{ __('التصنيف الأب') }}</label>
                                                            <select name="parent_id" id="parent_id"
                                                                class="form-control select2">
                                                                <option value="">{{ __('بدون تصنيف أب') }}</option>
                                                                @foreach ($categories as $cat)
                                                                    <option value="{{ $cat->id }}"
                                                                        {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                                                        {{ $cat->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!-- اللغة العربية -->
                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title">
                                                    <i class="ft-flag"></i> {{ __('اسم التصنيف') }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم التصنيف بالعربية') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('name.ar') }}" required
                                                                class="form-control" name="name[ar]"
                                                                placeholder="اسم التصنيف بالعربية">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم التصنيف بالعبرية') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('name.he') }}" required
                                                                class="form-control" name="name[he]"
                                                                placeholder="اسم التصنيف بالعبرية">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- اللغة العبرية -->


                                            <!-- الصورة -->
                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title">
                                                    <i class="ft-image"></i> {{ __('صورة التصنيف') }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('رفع صورة') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input image"
                                                                    id="image" name="image" accept="image/*">
                                                                <label class="custom-file-label"
                                                                    for="image">{{ __('اختر ملف') }}</label>
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ __('الأبعاد الموصى بها: 800x600 بكسل') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="image-preview-container text-center">
                                                            <img src="{{ asset('images/default-image.png') }}"
                                                                style="max-width: 200px; max-height: 150px;"
                                                                class="img-thumbnail image-preview mt-2" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!-- أزرار التحكم -->
                                            <div class="form-actions text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg mr-1">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ') }}
                                                </button>
                                                <button type="reset" class="btn btn-warning btn-lg mr-1">
                                                    <i class="la la-undo"></i> {{ __('إعادة تعيين') }}
                                                </button>
                                                <a href="{{ route('categories.index') }}" class="btn btn-danger btn-lg">
                                                    <i class="la la-close"></i> {{ __('إلغاء') }}
                                                </a>
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
            // Initialize Select2
            $('.select2').select2({
                placeholder: "{{ __('اختر تصنيف أب') }}",
                allowClear: true
            });

            // Update file input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            // Image preview functionality
            $(".image").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.image-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection
