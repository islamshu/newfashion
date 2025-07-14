@extends('layouts.master')
@section('title', __('تعديل ميزة'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل ميزة') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('features.index') }}">{{ __('المميزات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('تعديل ميزة') }}</li>
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
                                    <h4 class="card-title">{{ __('بيانات الميزة') }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body pt-0">
                                        @include('dashboard.inc.alerts')

                                        <form class="form" action="{{ route('features.update',$service->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('put')

                                            <!-- الإعدادات العامة -->


                                            <!-- اللغة العربية -->
                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title">
                                                    <i class="ft-flag"></i> {{ __('اسم الميزة') }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم الميزة بالعربية') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('title.ar',$service->getTranslation('title', 'ar')) }}" required
                                                                class="form-control" name="title[ar]"
                                                                placeholder="اسم الميزة بالعربية">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم الميزة بالعبرية') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" value="{{ old('title.he',$service->getTranslation('title', 'ar')) }} " required
                                                                class="form-control" name="title[he]"
                                                                placeholder="اسم الميزة بالعبرية">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title">
                                                    <i class="ft-flag"></i> {{ __('وصف الميزة') }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('وصف الميزة بالعربية') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea required class="form-control" name="description[ar]" rows="4" placeholder="وصف الميزة بالعربية">{{ old('description.ar',$service->getTranslation('description', 'ar')) }} </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('وصف الميزة بالعبرية') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea required class="form-control" name="description[he]" rows="4" placeholder="وصف الميزة بالعبرية">{{ old('description.he',$service->getTranslation('description', 'ar')) }} </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- اللغة العبرية -->


                                            <!-- الأيقونة -->
                                            <div class="form-section mb-4">
                                                <h5 class="form-section-title">
                                                    <i class="ft-image"></i> {{ __('أيقونة الميزة') }}
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('رفع أيقونة') }}</label>
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
                                                            <img src="{{ asset('storage/'.$service->icon) }}"
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
                                                <a href="{{ route('services.index') }}" class="btn btn-danger btn-lg">
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
