@extends('layouts.master')
@section('title', __('اعدادات الموقع'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إعدادات الموقع') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('إعدادات الموقع') }}</li>
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
                                    <h4 class="card-title">{{ __('إعدادات الموقع') }}</h4>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('add_general') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <!-- القسم العام -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-settings"></i> {{ __('الإعدادات العامة') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('شعار الموقع') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input imagee" id="website_logo" name="general_file[website_logo]">
                                                                <label class="custom-file-label" for="website_logo">{{ __('اختر ملف') }}</label>
                                                            </div>
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . get_general_value('website_logo')) }}" style="width: 120px; height: auto;" class="img-thumbnail image-previeww" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('أيقونة الموقع') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input image" id="website_icon" name="general_file[website_icon]">
                                                                <label class="custom-file-label" for="website_icon">{{ __('اختر ملف') }}</label>
                                                            </div>
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/' . get_general_value('website_icon')) }}" style="width: 60px; height: auto;" class="img-thumbnail image-preview" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('البريد الإلكتروني') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="ft-mail"></i></span>
                                                                </div>
                                                                <input type="email" value="{{ get_general_value('website_email') }}" class="form-control" name="general[website_email]" placeholder="info@example.com">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('هاتف الموقع') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="ft-phone"></i></span>
                                                                </div>
                                                                <input type="text" value="{{ get_general_value('phone') }}" class="form-control" name="general[phone]" placeholder="+123456789">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- قسم اللغة العربية -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-flag"></i> {{ __('إعدادات اللغة العربية') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم الموقع') }}</label>
                                                            <input type="text" value="{{ get_general_value('website_name_ar') }}" required class="form-control" name="general[website_name_ar]" placeholder="اسم الموقع بالعربية">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('وصف الموقع') }}</label>
                                                            <textarea name="general[description_ar]" class="form-control" rows="2" placeholder="وصف الموقع بالعربية">{{ get_general_value('description_ar') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{ __('عنوان الموقع') }}</label>
                                                            <textarea name="general[address_ar]" class="form-control" rows="2" placeholder="عنوان الموقع بالعربية">{{ get_general_value('address_ar') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- قسم اللغة العبرية -->
                                            <div class="form-section mb-4">
                                                <h5 class="section-title"><i class="ft-flag"></i> {{ __('إعدادات اللغة العبرية') }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('اسم الموقع') }}</label>
                                                            <input type="text" value="{{ get_general_value('website_name_he') }}" required class="form-control text-right" dir="rtl" name="general[website_name_he]" placeholder="שם האתר בעברית">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>{{ __('وصف الموقع') }}</label>
                                                            <textarea name="general[description_he]" class="form-control text-right" dir="rtl" rows="2" placeholder="תיאור האתר בעברית">{{ get_general_value('description_he') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{ __('عنوان الموقع') }}</label>
                                                            <textarea name="general[address_he]" class="form-control text-right" dir="rtl" rows="2" placeholder="כתובת האתר בעברית">{{ get_general_value('address_he') }}</textarea>
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
    // Script for file input label update
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
        
        $(".imagee").change(function() {
            readURL(this, '.image-previeww');
        });
        
        $(".image").change(function() {
            readURL(this, '.image-preview');
        });
    });
</script>

@endsection