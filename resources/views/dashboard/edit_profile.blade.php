@extends('layouts.master')
@section('title','تعديل الملف الشخصي')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل الملف الشخصي') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('تعديل الملف الشخصي') }}
                                </li>
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
                                    <h4 class="card-title">{{ __('تعديل الملف الشخصي') }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
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
                                    <div class="card-body form-section">
                                        <form class="form" id="send_full_employee">
                                            @csrf
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="la la-eye"></i> {{ __('تعديل الملف الشخصي') }}</h4>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput1">{{ __('الاسم') }}</label>
                                                        <span class="danger">*</span>
                                                        <input type="text" required id="userinput1" class="form-control border-primary" placeholder="{{ __('الاسم') }}" value="{{ auth()->user()->name }}" name="name">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput3">{{ __('البريد الإلكتروني') }}</label>
                                                        <span class="danger">*</span>
                                                        <input type="text" id="userinput3" required class="form-control border-primary" placeholder="{{ __('البريد الإلكتروني') }}" value="{{ auth()->user()->email }}" name="email">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('كلمة المرور') }}</label>
                                                    <span class="danger">*</span>
                                                    <input type="password" id="userinput4" class="form-control border-primary" placeholder="{{ __('كلمة المرور') }}" name="password">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('تأكيد كلمة المرور') }}</label>
                                                    <span class="danger">*</span>
                                                    <input type="password" id="userinput4" class="form-control border-primary" placeholder="{{ __('تأكيد كلمة المرور') }}" name="confirm_password">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="form-actions right">
                                                <button type="button" class="btn btn-warning mr-1">
                                                    <i class="ft-x"></i> {{ __('إلغاء') }}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ') }}
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
         $("#send_full_employee").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('edit_profile') }}",
                data: new FormData($('#send_full_employee')[0]),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        icon: 'success',
                        title: '{{ __('تم التعديل بنجاح') }}',
                    });
                    url="{{ asset('uploads/') }}";
                    image = "{{ auth()->user()->image }}"
                    $('.profile-image').attr('src', url+'/'+image);
                },
                error: function(response) {
                    $('.invalid-feedback').empty();
                    $('form').find('.is-invalid').removeClass('is-invalid');
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        var input = $('#send_full_employee').find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').html(messages[0]);
                    });
                }
            });
        });
    </script>
@endsection