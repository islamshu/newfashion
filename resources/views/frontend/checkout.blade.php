@extends('layouts.frontend')
@section('title', __('الدفع'))
@section('content')
    <!-- قسم شريط التصفح -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('المتجر') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('الدفع') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- قسم الدفع -->
    <div class="checkout-section pt-110 mb-110">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-7">
                    <div class="form-wrap mb-30">
                        <h4>{{ __('تفاصيل الفاتورة') }}</h4>
                        <form id="checkoutForm">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{ __('الاسم الأول') }}</label>
                                        <input type="text" name="fname" required
                                            placeholder="{{ __('ادخل اسمك الأول') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{ __('اسم العائلة') }}</label>
                                        <input type="text" name="lname" required
                                            placeholder="{{ __('ادخل اسم العائلة') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ __('عنوان الشارع') }}</label>
                                        <input type="text" name="address" required
                                            placeholder="{{ __('الشارع ورقم المنزل') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ __('المدينة') }}</label>
                                        <select id="citySelect">
                                            <option value="" data-fee="0">{{ __('اختر المدينة') }}</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" data-fee="{{ $city->delivery_fee }}">
                                                    {{ $city->getTranslation('name', 'ar') }} - رسوم التوصيل:
                                                    ₪{{ number_format($city->delivery_fee, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="city" id="hiddenCityInput" required>
                                        <div class="invalid-feedback" style="display: none; color: red; font-size: 14px;">
                                            {{ __(' يرجى اختيار المدينة.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="text" name="postcode" required
                                            placeholder="{{ __('الرمز البريدي') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ __('رقم الهاتف') }}</label>
                                        <input type="text" name="phone" required placeholder="{{ __('رقم الهاتف') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="email" name="email" required
                                            placeholder="{{ __('البريد الإلكتروني') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ __('ملاحظات الطلب (اختياري)') }}</label>
                                        <textarea name="message" rows="6" placeholder="{{ __('أدخل ملاحظاتك') }}"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div id="loadingSpinner" style="display:none; text-align:center; margin-bottom:10px;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">جاري المعالجة...</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100"
                                        id="submitOrderBtn">{{ __('إتمام الطلب') }}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


                <!-- ملخص الطلب والدفع -->
                <div class="col-lg-5">
                    <div id="cart-summary-wrapper">
                        @include('frontend.partials.cart_summary', ['cart' => $cart])
                    </div>

                    <div class="cost-summary mb-30">
                        <table class="table cost-summary-table">
                            <thead>
                                <tr>
                                    <th>{{ __('المجموع الفرعي') }}</th>
                                    <th id="subtotal-price">₪{{ number_format($subtotal ?? 0, 2) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="coupon-row" style="display:none;">
                                    <td id="coupon-label"></td>
                                    <td class="text-danger" id="coupon-discount">-₪0.00</td>
                                </tr>
                                <tr id="delivery-row" style="display:none;">
                                    <td>{{ __('رسوم التوصيل') }}</td>
                                    <td id="delivery-fee">₪0.00</td>
                                </tr>
                                <tr class="total">
                                    <th>{{ __('الإجمالي النهائي') }}</th>
                                    <th id="total-price">₪{{ number_format($subtotal ?? 0, 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="cost-summary total-cost mb-30">
                        <table class="table cost-summary-table total-cost">
                            <thead>
                                <tr>
                                    <th>{{ __('الإجمالي') }}</th>
                                    <th id="total-price">₪{{ number_format($total ?? 0, 2) }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="form-inner mb-4">
                        <label for="coupon">{{ __('أدخل كوبون الخصم') }}</label>
                        <div class="input-group">
                            <input type="text" id="coupon" name="coupon" class="form-control"
                                placeholder="{{ __('رمز الكوبون') }}" {{ session('applied_coupon') ? 'readonly' : '' }}>
                            <button type="button" id="applyCouponBtn" class="btn btn-primary"
                                {{ session('applied_coupon') ? 'disabled' : '' }}>
                                {{ __('تطبيق') }}
                            </button>
                            <button type="button" id="removeCouponBtn"
                                class="btn btn-danger {{ session('applied_coupon') ? '' : 'd-none' }}">
                                {{ __('إلغاء') }}
                            </button>
                        </div>
                        <div id="coupon-feedback" class="mt-2 small"></div>
                        <div id="city-required-alert" class="alert alert-warning mt-2 d-none">
                            <i class="fas fa-exclamation-circle"></i>{{__(' يجب اختيار المدينة أولاً قبل تطبيق الكوبون')}}
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = '{{ csrf_token() }}';
            const citySelect = $('#citySelect');
            const couponInput = $('#coupon');
            const applyBtn = $('#applyCouponBtn');
            const removeBtn = $('#removeCouponBtn');
            const feedback = $('#coupon-feedback');
            const subtotalRaw = parseFloat({{ $subtotal ?? 0 }});
            const discountRaw = parseFloat('{{ session('applied_coupon.discount', 0) }}') || 0;

            // تحديث السعر النهائي والواجهة
            function updatePriceSummary(deliveryFee = 0, discount = 0, subtotal = null) {
                const sub = subtotal !== null ? parseFloat(subtotal) : subtotalRaw;
                const disc = parseFloat(discount ?? discountRaw ?? 0);
                const total = sub + deliveryFee - disc;

                $('#subtotal-price').text('₪' + sub.toFixed(2));
                $('#coupon-discount').text('-₪' + disc.toFixed(2));
                $('#delivery-fee').text('₪' + deliveryFee.toFixed(2));
                $('#total-price').text('₪' + total.toFixed(2));

                if (disc > 0) $('#coupon-row').show();
                else $('#coupon-row').hide();

                if (deliveryFee > 0) $('#delivery-row').show();
                else $('#delivery-row').hide();
            }

            // عند تغيير المدينة
            citySelect.on('change', function() {
                const fee = parseFloat($(this).find(':selected').data('fee')) || 0;
                const hasCity = $(this).val() !== '';
                const selectedVal = $(this).val();
                $('#hiddenCityInput').val(selectedVal);

                if (selectedVal) {
                    $('.invalid-feedback').hide();
                    $('#citySelect').removeClass('is-invalid');
                }

                applyBtn.prop('disabled', !hasCity);
                if (!hasCity) {
                    feedback.text({{ __('يجب اختيار المدينة أولاً قبل تطبيق الكوبون') }}).removeClass(
                        'text-success').addClass('text-danger');
                } else {
                    feedback.text('');
                }

                updatePriceSummary(fee);
            });

            // تطبيق الكوبون
            applyBtn.on('click', function() {
                const code = couponInput.val().trim();
                const cityId = citySelect.val();

                if (!cityId) {
                    feedback.text({{ __('يجب اختيار المدينة أولاً قبل تطبيق الكوبون') }}).removeClass(
                        'text-success').addClass('text-danger');
                    return;
                }

                if (!code) return;

                $.ajax({
                    url: "{{ route('cart.applyCoupon') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        code,
                        city_id: cityId
                    },
                    success: function(data) {
                        if (data.error) {
                            feedback.text(data.error).removeClass('text-success').addClass(
                                'text-danger');
                        } else {
                            feedback.text("{{ __('تم تطبيق الكوبون بنجاح') }}")
                                .removeClass('text-danger').addClass('text-success');
                            couponInput.prop('readonly', true);
                            applyBtn.addClass('d-none');
                            removeBtn.removeClass('d-none');

                            const fee = parseFloat(citySelect.find(':selected').data('fee')) ||
                                0;
                            updatePriceSummary(fee, data.discount, data.subtotal);
                        }
                    },
                    error: function(xhr) {
                        const msg = xhr.responseJSON?.error ?? "{{ __('حدث خطأ غير متوقع') }}";
                        feedback.text(msg).removeClass('text-success').addClass('text-danger');
                    }
                });

            });

            // إزالة الكوبون
            removeBtn.on('click', function() {
                $.ajax({
                    url: "{{ route('cart.removeCoupon') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(data) {
                        couponInput.prop('readonly', false).val('');
                        applyBtn.removeClass('d-none').prop('disabled', !citySelect.val());
                        removeBtn.addClass('d-none');
                        feedback.text('');

                        const fee = parseFloat(citySelect.find(':selected').data('fee')) || 0;
                        updatePriceSummary(fee, 0, data.subtotal);
                    }
                });
            });

            // عند إرسال الطلب
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const selectedVal = $('#citySelect').val();
                if (!selectedVal) {
                    e.preventDefault();

                    // إظهار رسالة الخطأ
                    $('.invalid-feedback').show();

                    // إضافة كلاس خطأ على العنصر
                    $('#citySelect').addClass('is-invalid');

                    // فتح القائمة niceSelect
                    $('#citySelect').niceSelect('update');
                    $('#citySelect').niceSelect('open');
                }


                const loading = $('#loadingSpinner');
                const submitBtn = $('#submitOrderBtn');
                loading.show();
                submitBtn.prop('disabled', true);

                const formData = new FormData(this);
                const selectedOption = citySelect.find(':selected');
                const deliveryFee = parseFloat(selectedOption.data('fee')) || 0;
                const cityId = citySelect.val();

                formData.append('delivery_fee', deliveryFee);
                formData.append('city_id', cityId);

                fetch("{{ route('checkout.placeOrder') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        loading.hide();
                        submitBtn.prop('disabled', false);
                        if (data.success) {
                            Swal.fire({
                                title: {{ __('تم الطلب!') }},
                                text: data.message,
                                icon: 'success'
                            }).then(() => window.location.href = "/order/" + data.order_code);
                        } else {
                            Swal.fire({{ __('خطأ!') }}, data.message || {{ __('حدث خطأ ما') }},
                                'error');
                        }
                    })
                    .catch(() => {
                        loading.hide();
                        submitBtn.prop('disabled', false);
                        Swal.fire({{ __('خطأ!') }}, {{ __('فشل إرسال الطلب.') }}, 'error');
                    });
            });

            // تهيئة أولية (إذا كانت المدينة مختارة مسبقاً)
            const selected = citySelect.find(':selected');
            if (selected.val() !== '') {
                applyBtn.prop('disabled', false);
                updatePriceSummary(parseFloat(selected.data('fee')) || 0);
            }
        });
    </script>
@endsection
