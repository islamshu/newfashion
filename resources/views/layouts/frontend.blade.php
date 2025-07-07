<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/assets/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icon CSS -->
    <link href="{{ asset('front/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Fontawesome all CSS -->
    <link href="{{ asset('front/assets/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/animate.min.css') }}" rel="stylesheet">
    <!--  FancyBox CSS  -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/jquery.fancybox.min.css') }}"> <!-- Fontawesome CSS -->
    <link href="{{ asset('front/assets/css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- box icon css -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/boxicons.min.css') }}">
    <!-- slider CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/slick.css') }}">
    <!--  Style CSS  -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-rtl.css') }}">
    <title>{{ get_general_value('website_name_' . app()->getLocale()) }}</title>
    <link rel="apple-touch-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

</head>

<body>
    @include('frontend.model_when_open')
    @include('frontend.top_bar')
    @include('frontend.login_register_model')
    @include('frontend.header')
    @include('frontend.sliders')
    @include('frontend.featchers')
    @include('frontend.categorires')
    @include('frontend.best_sellling')
    {{-- @include('frontend.product_with_category') --}}
    @include('frontend.banners')
    {{-- @include('frontend.new_products') --}}
    {{-- @include('frontend.exclosive') --}}
    {{-- @include('frontend.offers') --}}
    {{-- @include('frontend.best_brands') --}}
    @include('frontend.say_about')
    {{-- @include('frontend.blogs') --}}
    @include('frontend.newsletter')
    {{-- @include('frontend.instegram') --}}
    @include('frontend.footer')
    <div class="modal product-view-modal"id="product-view-modal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- سيتم تعبئة المحتوى هنا عبر AJAX -->
                <div class="modal-body text-center p-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">{{ __('جاري التحميل ... ') }} </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script data-cfasync="false" src="{{ asset('front/assets/js/cloudflare-static/email-decode.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="{{ asset('front/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- Fancybox JS -->
    <script src="{{ asset('front/assets/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/slick.js') }}"></script>
    <!-- Swiper slider JS -->
    <script src="{{ asset('front/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/waypoints.min.js') }}"></script>
    <!-- main js  -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.view-product-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    let productId = this.dataset.id;

                    // عرض رسالة جاري التحميل داخل modal-content (تغطي كل المحتوى)
                    document.querySelector('#product-view-modal .modal-content').innerHTML = `
                <div class="modal-body text-center p-5">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">جاري التحميل ...</span>
                    </div>
                </div>
            `;

                    // فتح المودال
                    $('#product-view-modal').modal('show');

                    // تحميل المحتوى من السيرفر
                    fetch(`/products/${productId}/modal`)
                        .then(response => response.text())
                        .then(html => {
                            // استبدال المحتوى بالنتيجة من السيرفر
                            document.querySelector('#product-view-modal .modal-content')
                                .innerHTML = html;
                        })
                        .catch(err => {
                            alert("حدث خطأ أثناء تحميل تفاصيل المنتج.");
                            console.error(err);
                        });
                });
            });
        });
    </script>

    <script>
        var isLoggedIn = @json(Auth::guard('client')->check());
    </script>
    <script>
      $(document).ready(function() {
    // استخدام event delegation
    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();

        var productId = $(this).data('product-id');
        var button = $(this);

        if (!isLoggedIn) {
            const swalTitle = "{{ __('يجب تسجيل الدخول') }}";
            const swalText = "{{ __('يرجى تسجيل الدخول أولاً لإضافة المنتج إلى المفضلة.') }}";
            const swalConfirm = "{{ __('حسناً') }}";

            Swal.fire({
                icon: 'warning',
                title: swalTitle,
                text: swalText,
                confirmButtonText: swalConfirm
            });
            return;
        }

        $.ajax({
            url: '/wishlist/add',
            method: 'POST',
            data: {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    button.addClass('active');
                    Swal.fire({
                        icon: 'success',
                        title: "{{ __('تم الاضافة الى المفضلة') }}",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    button.removeClass('active');
                    Swal.fire({
                        icon: 'info',
                        title: "{{ __('تم الحذف من المفضلة') }}",
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: "{{ __('خطأ') }}",
                    text: "{{ __('حدث خطأ أثناء إضافة المنتج إلى المفضلة.') }}",
                });
            }
        });
    });
});

    </script>
    <script>
        // لمنع إدخال أي شيء غير الأرقام في حقول الهاتف
        document.querySelectorAll('input[type="tel"]').forEach(function(input) {
            input.addEventListener('keypress', function(e) {
                if (isNaN(String.fromCharCode(e.which))) {
                    e.preventDefault();
                }
            });
        });

        // سكربت لإظهار وإخفاء كلمة المرور
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove('bi-eye-slash');
                    this.classList.add('bi-eye');
                } else {
                    input.type = "password";
                    this.classList.remove('bi-eye');
                    this.classList.add('bi-eye-slash');
                }
            });
        });
    </script>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ __('تم إرسال رمز التحقق') }}",
                            text: data.message,
                        });

                        document.getElementById('register-form').style.display = 'none';
                        document.getElementById('otp-section-register').style.display = 'block';

                        // إظهار زر إعادة الإرسال (إن لم يكن ظاهرًا)
                        document.getElementById('resend-otp-btn').style.display = 'inline-block';
                    } else if (data.errors) {
                        let errors = Object.values(data.errors).flat().join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('خطأ في التحقق') }}",
                            html: errors,
                        });
                    }
                })

                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('خطأ غير متوقع') }}",
                        text: "{{ __('يرجى المحاولة لاحقاً.') }}",
                    });
                });
        });
    </script>

    <script>
        document.getElementById('otp-form-register').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            fetch("{{ route('otp.verify') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ __('تم التحقق') }}",
                            text: "{{ __('تم إنشاء الحساب وتسجيل الدخول بنجاح.') }}",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = data.redirect_to;
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('رمز غير صحيح') }}",
                            text: data.message || "{{ __('رمز التحقق غير صحيح.') }}",
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('خطأ') }}",
                        text: "{{ __('حدث خطأ أثناء التحقق.') }}",
                    });
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // إرسال نموذج تسجيل الدخول
            document.getElementById('login-form').addEventListener('submit', function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: "{{ __('تم تسجيل الدخول') }}",
                                text: data.message || "{{ __('مرحباً بعودتك!') }}",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.href = data.redirect_to || '/dashboard';
                            });

                        } else if (data.requires_otp) {
                            Swal.fire({
                                icon: 'info',
                                title: "{{ __('التحقق مطلوب') }}",
                                text: data.message ||
                                    "{{ __('حسابك لم يتم التحقق منه، يرجى إدخال رمز التحقق.') }}",
                            });

                            // إخفاء نموذج الدخول
                            form.style.display = 'none';

                            // إظهار نموذج OTP
                            document.getElementById('otp-section-login').style.display = 'block';
                            document.getElementById('resend-otp-btn').style.display = 'inline-block';

                        } else if (data.errors) {
                            let errors = Object.values(data.errors).flat().join('<br>');
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('خطأ في تسجيل الدخول') }}",
                                html: errors,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('خطأ') }}",
                                text: data.message || "{{ __('بيانات الدخول غير صحيحة.') }}",
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('خطأ غير متوقع') }}",
                            text: "{{ __('يرجى المحاولة لاحقاً.') }}",
                        });
                    });
            });

            // إرسال نموذج التحقق من OTP
            document.getElementById('otp-form-login').addEventListener('submit', function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                fetch("{{ route('otp.verify') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: "{{ __('تم التحقق') }}",
                                text: "{{ __('تم تسجيل الدخول بنجاح.') }}",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.href = data.redirect_to || '/dashboard';
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('رمز غير صحيح') }}",
                                text: data.message || "{{ __('رمز التحقق غير صحيح.') }}",
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('خطأ') }}",
                            text: "{{ __('حدث خطأ أثناء التحقق.') }}",
                        });
                    });
            });

            // زر إعادة إرسال رمز التحقق
            document.getElementById('resend-otp-btn').addEventListener('click', function() {
                fetch("{{ route('resend.otp') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.success ? 'success' : 'error',
                            title: data.success ? "{{ __('تم الإرسال') }}" :
                                "{{ __('خطأ') }}",
                            text: data.message,
                        });
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('خطأ') }}",
                            text: "{{ __('تعذر إعادة إرسال الرمز.') }}",
                        });
                    });
            });

        });
    </script>
    <script>
        $(document).on('click', '.quantity__plus', function() {
            var input = $(this).siblings('.quantity__input');
            var currentVal = parseInt(input.val()) || 1;
            input.val(currentVal + 1);
        });

        $(document).on('click', '.quantity__minus', function() {
            var input = $(this).siblings('.quantity__input');
            var currentVal = parseInt(input.val()) || 1;
            if (currentVal > 1) {
                input.val(currentVal - 1);
            }
        });
    </script>



</body>

</html>
