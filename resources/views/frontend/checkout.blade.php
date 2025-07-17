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
                                        <select name="city" required>
                                            <option value="">{{ __('اختر المدينة') }}</option>
                                            <optgroup label="الداخل الفلسطيني">
                                                <option value="الناصرة">الناصرة</option>
                                                <option value="حيفا">حيفا</option>
                                                <option value="عكا">عكا</option>
                                                <option value="يافا">يافا</option>
                                                <option value="اللد">اللد</option>
                                                <option value="الرملة">الرملة</option>
                                                <option value="سخنين">سخنين</option>
                                                <option value="أم الفحم">أم الفحم</option>
                                                <option value="رهط">رهط</option>
                                                <option value="كفر قاسم">كفر قاسم</option>
                                                <option value="الطيبة">الطيبة</option>
                                            </optgroup>
                                            <optgroup label="الضفة الغربية">
                                                <option value="رام الله">رام الله</option>
                                                <option value="نابلس">نابلس</option>
                                                <option value="الخليل">الخليل</option>
                                                <option value="بيت لحم">بيت لحم</option>
                                                <option value="طولكرم">طولكرم</option>
                                                <option value="قلقيلية">قلقيلية</option>
                                                <option value="جنين">جنين</option>
                                                <option value="أريحا">أريحا</option>
                                                <option value="سلفيت">سلفيت</option>
                                                <option value="طوباس">طوباس</option>
                                            </optgroup>
                                        </select>
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
                                    <button type="submit" class="btn btn-primary w-100">{{ __('إتمام الطلب') }}</button>
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
                                <tr>
                                    <td class="tax">{{ __('الضريبة') }}</td>
                                    <td id="tax-price">₪{{ number_format($tax ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('المجموع (بدون ضريبة)') }}</td>
                                    <td id="total-excl-tax">₪{{ number_format($subtotal ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('المجموع (مع الضريبة)') }}</td>
                                    <td id="total-incl-tax">₪{{ number_format($totalInclTax ?? 0, 2) }}</td>
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
                                placeholder="{{ __('رمز الكوبون') }}">
                            <button type="button" id="applyCouponBtn"
                                class="btn btn-primary">{{ __('تطبيق') }}</button>
                            <button type="button" id="removeCouponBtn"
                                class="btn btn-danger d-none">{{ __('إلغاء') }}</button>
                        </div>
                        <div id="coupon-feedback" class="mt-2 small text-danger"></div>
                    </div>




                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cart-summary-wrapper').addEventListener('click', function(e) {
                if (e.target.closest('.remove-item-checkout')) {
                    e.preventDefault();
                    let button = e.target.closest('.remove-item-checkout');
                    let index = button.getAttribute('data-index');
                    if (!index) return;

                    fetch("{{ route('cart.removeItem') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                index: index
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // تحديث قائمة المنتجات
                            document.getElementById('cart-summary-wrapper').innerHTML = data.html;

                            // تحديث الأسعار
                            document.getElementById('subtotal-price').textContent = '$' + data.subtotal;
                            document.getElementById('tax-price').textContent = '$' + data.tax;
                            document.getElementById('total-excl-tax').textContent = '$' + data
                                .totalExclTax;
                            document.getElementById('total-incl-tax').textContent = '$' + data
                                .totalInclTax;
                            document.getElementById('total-price').textContent = '$' + data.total;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applyBtn = document.getElementById('applyCouponBtn');
            const removeBtn = document.getElementById('removeCouponBtn');
            const couponInput = document.getElementById('coupon');
            const feedback = document.getElementById('coupon-feedback');

            applyBtn.addEventListener('click', function() {
                const code = couponInput.value.trim();
                if (!code) return;

                fetch("{{ route('cart.applyCoupon') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            code: code
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            feedback.textContent = data.error;
                        } else {
                            feedback.textContent = '';
                            updatePrices(data);
                            showCouponRow(data.discountLabel, data.discount);
                            applyBtn.classList.add('d-none');
                            removeBtn.classList.remove('d-none');
                            couponInput.setAttribute('readonly', true);
                        }
                    })
                    .catch(() => feedback.textContent = '{{ __('حدث خطأ ما') }}');
            });

            removeBtn.addEventListener('click', function() {
                fetch("{{ route('cart.removeCoupon') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        feedback.textContent = '';
                        updatePrices(data);
                        removeCouponRow();
                        applyBtn.classList.remove('d-none');
                        removeBtn.classList.add('d-none');
                        couponInput.removeAttribute('readonly');
                        couponInput.value = '';
                    });
            });

            function updatePrices(data) {
                document.getElementById('subtotal-price').textContent = '₪' + data.subtotal;
                document.getElementById('tax-price').textContent = '₪' + data.tax;
                document.getElementById('total-excl-tax').textContent = '₪' + data.totalInclTax;
                document.getElementById('total-incl-tax').textContent = '₪' + data.totalInclTax;
                document.getElementById('total-price').textContent = '₪' + data.total;
            }

            function showCouponRow(label, discount) {
                let row = document.getElementById('coupon-row');
                if (!row) {
                    row = document.createElement('tr');
                    row.id = 'coupon-row';
                    document.querySelector('.cost-summary-table tbody').appendChild(row);
                }
                row.innerHTML = `<td>${label}</td><td class="text-danger">-₪${discount}</td>`;
            }

            function removeCouponRow() {
                let row = document.getElementById('coupon-row');
                if (row) row.remove();
            }
        });
    </script>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch("{{ route('checkout.placeOrder') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'تم الطلب!',
                            text: data.message,
                            icon: 'success'
                        }).then(() => {
                          const orderCode = data.code; // يجب أن ترسله من السيرفر
                          window.location.href = "/order/" + orderCode;
                        });
                    } else {
                        Swal.fire('خطأ!', data.message || 'حدث خطأ ما', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('خطأ!', 'فشل إرسال الطلب.', 'error');
                });
            });
        });
    </script>
@endsection
