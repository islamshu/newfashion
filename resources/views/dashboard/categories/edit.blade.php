@extends('layouts.master')
@section('title', __('تعديل التصنيف'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل التصنيف') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('التصنيفات') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تعديل التصنيف') }}</li>
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
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body"> 
                                        @include('dashboard.inc.alerts')
                                        <form class="form" action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <!-- قسم اللغة العربية -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-flag"></i> {{ __('اسم التصنيف') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم التصنيف بالعربية') }}</label>
                                                            <input type="text" value="{{ $category->getTranslation('name', 'ar') }}" required class="form-control" name="name[ar]" placeholder="اسم التصنيف بالعربية">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم التصنيف بالعبرية') }}</label>
                                                            <input type="text" value="{{ $category->getTranslation('name', 'he') }}" required class="form-control" name="name[he]" placeholder="اسم التصنيف بالعبرية">
                                                        </div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                            
                                        
                                            
                                            <!-- القسم العام -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-settings"></i> {{ __('الإعدادات العامة') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('الصورة') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input image" id="image" name="image">
                                                                <label class="custom-file-label" for="image">{{ __('اختر ملف') }}</label>
                                                            </div>
                                                            <div class="mt-2">
                                                                <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/default-image.png') }}" style="width: 120px; height: auto;" class="img-thumbnail image-preview" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            
                                                            
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>{{ __('الحالة') }}</label>
                                                                    <select name="status" class="form-control" required>
                                                                        <option value="1" {{ $category->status ? 'selected' : '' }}>{{ __('مفعل') }}</option>
                                                                        <option value="0" {{ !$category->status ? 'selected' : '' }}>{{ __('غير مفعل') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
<script>
    $(document).ready(function(){
        $('.custom-file-input').on('change', function(){
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
        
        // Image preview functionality
        function readURL(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(preview).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $(".image").change(function() {
            readURL(this, '.image-preview');
        });
    });
</script>
@endsection