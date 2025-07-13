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
    <title>{{ get_general_value('website_name_' . app()->getLocale()) }} - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

</head>

<body>
    @include('frontend.top_bar')
    @include('frontend.login_register_model')
    @include('frontend.header')
    @yield('content')
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
            document.body.addEventListener('click', function(event) {
                const target = event.target.closest('.view-product-btn');
                if (!target) return;

                let productId = target.dataset.id;

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
                        document.querySelector('#product-view-modal .modal-content').innerHTML = html;
                        initializeProductModalScripts();
                    })
                    .catch(err => {
                        alert("حدث خطأ أثناء تحميل تفاصيل المنتج.");
                        console.error(err);
                    });
            });
        });
    </script>

    <script>
        var isLoggedIn = @json(Auth::guard('client')->check());
        const isWishlistPage = @json(Route::is('client.wishlist'));
    </script>
    <script>
        $(document).ready(function() {
            $.get('/cart/mini', function(html) {
                $('.cart-menu').html(html);
            });

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
                            if (isWishlistPage) {
                                // إعادة تحميل قائمة المنتجات
                                $.get("{{ route('client.wishlist.reload') }}", function(data) {
                                    $('#whishlistContainer').html(data.html);
                                });
                            }
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
    @if (!request()->routeIs('product.show'))
        <script>
            function initializeProductModalScripts() {

                const productId = $('#product_id').val();
                let currentStock = 1;

                const $colorInputs = $('input[name="color_id"]');
                const $sizeContainer = $('.size-list');
                const $stockLabel = $('.stock-available');
                const $quantityInput = $('.quantity__input');
                $quantityInput.val('1')

                function fetchSizes(colorId = null) {
                    $sizeContainer.html(`
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">جارٍ التحميل...</span>
                    </div> {{ __('جاري التحميل ...') }}
                `);

                    $.get('/get-sizes', {
                        product_id: productId,
                        color_id: colorId
                    }, function(sizes) {
                        let html = '';
                        sizes.forEach((size, index) => {
                            const isChecked = index === 0 ? 'checked' : '';
                            html += `
                <li>
                    <input type="radio" name="size_id" id="size-${size.id}" value="${size.id}" class="size-radio" hidden ${isChecked}>
                    <label for="size-${size.id}" class="size-option">${size.value}</label>
                </li>
            `;
                        });

                        $sizeContainer.html(html);

                        // بعد تحميل الأحجام وتحديد أول واحدة، احضر المخزون تلقائيًا
                        const selectedSizeId = sizes.length > 0 ? sizes[0].id : null;
                        const selectedColorId = $('input[name="color_id"]:checked').val() || null;
                        fetchStock(productId, selectedColorId, selectedSizeId);
                    });
                }


                function fetchStock(productId, colorId = null, sizeId = null) {
                    // 🌀 عرض لودر
                    $stockLabel.html(`
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                    <span class="visually-hidden">جارٍ التحميل...</span>
                                </div> {{ __('جاري التحميل ...') }}
                                `);

                    $.get('/get-stock', {
                        product_id: productId,
                        color_id: colorId,
                        size_id: sizeId
                    }, function(response) {
                        currentStock = response.stock || 1;

                        let label = $stockLabel.data('stock-label');
                        $stockLabel.text(label + ': ' + currentStock);
                        $quantityInput.data('max-stock', currentStock);
                    });
                }


                // عرض الأحجام إذا لم توجد ألوان
                if ($colorInputs.length === 0) {
                    fetchSizes();
                } else {
                    // عرض الأحجام حسب أول لون محدد افتراضيًا
                    const defaultColorId = $('input[name="color_id"]:checked').val();
                    fetchSizes(defaultColorId);
                }

                // عند اختيار لون، تحديث المقاسات
                $(document).on('change', 'input[name="color_id"]', function() {
                    const colorId = $(this).val();
                    fetchSizes(colorId);
                });

                // عند اختيار مقاس أو لون
                $(document).on('change', 'input[name="size_id"], input[name="color_id"]', function() {
                    const colorId = $('input[name="color_id"]:checked').val() || null;
                    const sizeId = $('input[name="size_id"]:checked').val() || null;

                    fetchStock(productId, colorId, sizeId);
                });

                // التحكم في الكمية
                $(document).off('click', '.quantity__plus').on('click', '.quantity__plus', function() {
                    let $input = $(this).siblings('.quantity__input');
                    if ($input.length === 0) {
                        $input = $('.quantity__input');
                    }


                    let val = parseInt($input.val()) || 1;
                    let max = $input.data('max-stock') || 1;

                    if (val < max) {
                        $input.val(val + 1);
                    }
                });

                $(document).off('click', '.quantity__minus').on('click', '.quantity__minus', function() {
                    let $input = $(this).siblings('.quantity__input');
                    if ($input.length === 0) {
                        $input = $('.quantity__input');
                    }

                    let val = parseInt($input.val()) || 1;

                    if (val > 1) {
                        $input.val(val - 1);
                    }
                });



                // trigger initial stock load
                setTimeout(function() {
                    const colorId = $('input[name="color_id"]:checked').val() || null;
                    const sizeId = $('input[name="size_id"]:checked').val() || null;
                    fetchStock(productId, colorId, sizeId);
                }, 300);
            };
        </script>
        <script>
            $(document).on('click', '#add-to-cart-btn', function(e) {
                e.preventDefault();

                // البحث داخل المودال فقط
                const $modal = $(this).closest('.modal');

                const productId = $modal.find('#product_id').val();
                const quantity = $modal.find('.quantity__input').val();
                const colorId = $modal.find('input[name="color_id"]:checked').val();
                const sizeId = $modal.find('input[name="size_id"]:checked').val();

                $.ajax({
                    url: '{{ route('cart.add') }}', // تأكد أن هذا route موجود في Laravel
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity,
                        color_id: colorId,
                        size_id: sizeId,
                    },
                    beforeSend: function() {
                        $('#add-to-cart-btn').html(
                            '<span class="spinner-border spinner-border-sm"></span> {{ __('جاري الإضافة...') }}'
                        ).prop('disabled', true);
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تمت الإضافة',
                            text: response.message || 'تم إضافة المنتج إلى السلة بنجاح!',
                        });

                        // إعادة الزر لحالته الطبيعية
                        if (response.cart_count !== undefined) {
                            $('#cart-count').text(response.cart_count);
                        }
                        $.get('/cart/mini', function(html) {
                            $('.cart-menu').html(html);
                        });

                        $('#add-to-cart-btn').html('{{ __('أضف إلى السلة') }}').prop('disabled', false);
                        // يمكنك أيضًا تحديث عدد السلة في الهيدر
                        // updateCartCount(response.cart_count);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: xhr.responseJSON?.message || 'فشل في إضافة المنتج إلى السلة!',
                        });

                        $('#add-to-cart-btn').html('{{ __('أضف إلى السلة') }}').prop('disabled', false);
                    }
                });
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.remove-item', function() {
            let productId = $(this).data('id');

            $.ajax({
                url: '{{ route('cart.remove') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    $('.cart-menu').html(response.cart_html); // ← يتم إرسال HTML من السيرفر
                    // اختياري: تحديث عدد المنتجات بجوار أيقونة السلة
                    $('.header-cart-btn span').text(response.cart_count);
                },
                error: function() {
                    alert('حدث خطأ أثناء حذف المنتج.');
                }
            });
        });


        function updateCartMenu() {
            $.ajax({
                url: '/cart/mini', // يرجع فقط محتوى السلة
                success: function(html) {
                    $('.cart-menu').html(html);
                },
                error: function() {
                    console.error("فشل تحديث السلة");
                }
            });
        }
    </script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector('.search-area form');
    const searchInput = searchForm.querySelector('input[type="text"]');
    const resultsBox = document.getElementById('searchResults');

    // منع إعادة تحميل الصفحة عند الضغط زر البحث
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        if(query.length < 2) {
            resultsBox.style.display = 'none';
            resultsBox.innerHTML = '';
            return;
        }
        performSearch(query);
    });

    // البحث أثناء الكتابة (مع تأخير 300ms)
    let debounce;
    searchInput.addEventListener('keyup', function(e) {
        if(e.key === "Enter") return; // تجاهل enter هنا لأن الفورم يرسل البحث

        const query = this.value.trim();
        clearTimeout(debounce);

        if(query.length < 2) {
            resultsBox.style.display = 'none';
            resultsBox.innerHTML = '';
            return;
        }

        debounce = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    function performSearch(keyword) {
        fetch(`{{ route('products.quickSearch') }}?name=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
            if(data.length > 0) {
                resultsBox.innerHTML = data.map(item => `
                    <a href="/product/${item.id}" class="search-result-item" style="display:flex;align-items:center;gap:10px;padding:8px 12px;border-bottom:1px solid #eee;text-decoration:none;color:#333;">
                        <img src="${item.image}" alt="${item.name}" style="width:50px;height:50px;object-fit:cover;border-radius:5px;flex-shrink:0;">
                        <div>
                            <div style="font-weight:bold;">${item.name}</div>
                            <div style="color:#28a745;font-weight:600;">${item.price} ₪</div>
                        </div>
                    </a>
                `).join('');
                resultsBox.style.display = 'block';
            } else {
                resultsBox.innerHTML = '<div style="padding:10px;text-align:center;color:#777;">لا توجد نتائج</div>';
                resultsBox.style.display = 'block';
            }
        })
        .catch(() => {
            resultsBox.innerHTML = '<div style="padding:10px;text-align:center;color:red;">حدث خطأ في البحث</div>';
            resultsBox.style.display = 'block';
        });
    }

    // إخفاء النتائج عند الضغط خارج صندوق البحث
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.style.display = 'none';
        }
    });
});
</script>




    @yield('scripts')




</body>

</html>
