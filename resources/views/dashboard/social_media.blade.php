@extends('layouts.master')
@section('title','إعدادات وسائل التواصل الاجتماعي')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إعدادات وسائل التواصل الاجتماعي') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('وسائل التواصل الاجتماعي') }}</li>
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
                                    <h4 class="card-title">{{ __('روابط وسائل التواصل الاجتماعي') }}</h4>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('save_social_media') }}" method="post">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- فيسبوك -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="facebook_url">{{ __('فيسبوك') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-primary text-white">
                                                                        <i class="la la-facebook"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="url" class="form-control" id="facebook_url" 
                                                                       name="social[facebook]" 
                                                                       value="{{ get_social_value('facebook') }}"
                                                                       placeholder="https://facebook.com/username">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- تويتر -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="twitter_url">{{ __('تويتر') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-info text-white">
                                                                        <i class="la la-twitter"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="url" class="form-control" id="twitter_url" 
                                                                       name="social[twitter]" 
                                                                       value="{{ get_social_value('twitter') }}"
                                                                       placeholder="https://twitter.com/username">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- إنستغرام -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="instagram_url">{{ __('إنستغرام') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-danger text-white">
                                                                        <i class="la la-instagram"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="url" class="form-control" id="instagram_url" 
                                                                       name="social[instagram]" 
                                                                       value="{{ get_social_value('instagram') }}"
                                                                       placeholder="https://instagram.com/username">
                                                            </div>
                                                        </div>
                                                    </div>

                                                  
                                                </div>

                                                <div class="row">
                                              

                                                    <!-- سناب شات -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="snapchat_url">{{ __('سناب شات') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-warning text-white">
                                                                        <i class="la la-snapchat"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="url" class="form-control" id="snapchat_url" 
                                                                       name="social[snapchat]" 
                                                                       value="{{ get_social_value('snapchat') }}"
                                                                       placeholder="https://snapchat.com/add/username">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- تيك توك -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tiktok_url">{{ __('تيك توك') }}</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark text-white">
                                                                        <i class="la la-music"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="url" class="form-control" id="tiktok_url" 
                                                                       name="social[tiktok]" 
                                                                       value="{{ get_social_value('tiktok') }}"
                                                                       placeholder="https://tiktok.com/@username">
                                                            </div>
                                                        </div>
                                                    </div>

                                                   
                                                </div>
                                            </div>

                                            <!-- زر الحفظ -->
                                            <div class="form-actions right">
                                                <button type="submit" class="btn btn-primary">
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
        // يمكنك إضافة أي سكريبتات تحتاجها هنا
        $(document).ready(function() {
            // تأكيد حفظ الإعدادات
            $('form').on('submit', function() {
                toastr.success('تم حفظ إعدادات وسائل التواصل الاجتماعي بنجاح');
            });
        });
    </script>
@endsection

<style>
    .btn-social {
        color: white;
        width: 100%;
        text-align: left;
        margin-bottom: 10px;
    }
    .btn-facebook { background-color: #3b5998; }
    .btn-twitter { background-color: #1DA1F2; }
    .btn-instagram { background-color: #E1306C; }
    .btn-linkedin { background-color: #0077B5; }
    .btn-youtube { background-color: #FF0000; }
    .btn-snapchat { background-color: #FFFC00; color: #000; }
    .btn-tiktok { background-color: #000000; }
    .btn-whatsapp { background-color: #25D366; }
    
    .input-group-text {
        min-width: 40px;
        justify-content: center;
    }
    
    .social-media-preview {
        background: #f8f8f8;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #eee;
    }
</style>