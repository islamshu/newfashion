@extends('layouts.frontend')
@section('title', __('تتبع الطلب'))
@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('تتبع الطلب') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="order-tracking-section mt-110 mb-110">
        <div class="container">
            <!-- قسم إدخال رقم الطلب -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="order-tracking-box box--shadow p-5 rounded-4 ">
                        <h3 class="mb-4 fw-bold text-dark">{{ __('تتبع طلبك') }}</h3>
                        <form id="orderTrackingForm" novalidate>
                            <div class="row g-4">
                                <div class="col-md-8" dir="ltr">
                                    <div class="form-inner">
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">ORD-</span>
                                            <input type="text" name="tracking_number"
                                                placeholder="{{ __('أدخل رقم الطلب') }}" class="form-control border-dark"
                                                required>
                                        </div>
                                        <div class="invalid-feedback text-danger mt-1" id="tracking-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-grid">
                                    <button type="submit" class="btn btn-dark fw-bold">
                                        {{ __('تتبع الطلب') }} <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- قسم عرض نتائج التتبع -->
                    <div id="orderTrackingResult" class="mt-5" style="display: none;">
                        <div class="order-details-box p-5 rounded-4 shadow-lg bg-white border border-gray-200">
                            <!-- محتوى تفاصيل الطلب سيُضاف هنا -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* تصميم فاخر وأنيق */
        .order-tracking-section {
            position: relative;
            background: url('{{ Storage::url(get_general_value('track_image_cover')) }}') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            background-color: #f9f9f9;
            z-index: 1;
            padding: 80px 0;
        }


        /* لون النص للحالات */
        .text-warning {
            color: #f59e0b !important;
        }

        /* أصفر */
        .text-info {
            color: #0d6efd !important;
        }

        /* أزرق */
        .text-success {
            color: #198754 !important;
        }

        /* أخضر */
        .text-danger {
            color: #dc3545 !important;
        }

        /* أحمر */
        .text-secondary {
            color: #6c757d !important;
        }

        /* رمادي */
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // عند تحميل الصفحة إذا كان هناك رقم طلب في الرابط
            const urlParams = new URLSearchParams(window.location.search);
            const orderCode = urlParams.get('order_code');
            if (orderCode) {
                $('#orderTrackingForm input[name="tracking_number"]').val(orderCode.replace('ORD-', ''));
                trackOrder(orderCode);
            }

            // تعامل مع نموذج التتبع
            $('#orderTrackingForm').on('submit', function(e) {
                e.preventDefault();
                const trackingNumber = $('input[name="tracking_number"]').val().trim();
                const fullOrderCode = 'ORD-' + trackingNumber;

                if (!trackingNumber) {
                    $('#tracking-error').text('{{ __('الرجاء إدخال رقم الطلب') }}');
                    $('#orderTrackingResult').hide();
                    return;
                }

                $('#tracking-error').text('');
                // تحديث URL بدون إعادة تحميل الصفحة
                history.pushState(null, null, '?order_code=' + fullOrderCode);
                trackOrder(fullOrderCode);
            });

            function trackOrder(orderCode) {
                // عرض مؤشر تحميل
                $('#orderTrackingResult').show();
                $('#orderTrackingResult .order-details-box').html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-dark" role="status">
                            <span class="visually-hidden">{{ __('جاري التحميل...') }}</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('order.track') }}",
                    method: 'POST',
                    data: {
                        order_code: orderCode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            displayOrderDetails(response.order);
                        } else {
                            $('#orderTrackingResult .order-details-box').html(`
                                <div class="alert alert-danger text-center py-4">
                                    ${response.message}
                                </div>
                            `);
                        }
                    },
                    error: function() {
                        $('#orderTrackingResult .order-details-box').html(`
                            <div class="alert alert-danger text-center py-4">
                                {{ __('حدث خطأ أثناء محاولة تتبع الطلب') }}
                            </div>
                        `);
                    }
                });
            }

            function displayOrderDetails(order) {
                if (!order || !order.items || !Array.isArray(order.items)) {
                    $('#orderTrackingResult .order-details-box').html(`
                        <div class="alert alert-danger text-center py-4">
                            {{ __('بيانات الطلب غير متوفرة أو غير صالحة') }}
                        </div>
                    `);
                    return;
                }

                const orderDate = new Date(order.created_at).toLocaleDateString('ar-EG', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                let statusClass = '';
                let statusText = '';
                switch (order.status) {
                    case 'pending':
                        statusClass = 'text-warning';
                        statusText = '{{ __('قيد المعالجة') }}';
                        break;
                    case 'processing':
                        statusClass = 'text-info';
                        statusText = ' {{ __('قيد التنفيذ') }}';
                        break;
                    case 'completed':
                        statusClass = 'text-success';
                        statusText = '{{ __('مكتمل') }}';
                        break;
                    case 'cancelled':
                        statusClass = 'text-danger';
                        statusText = '{{ __('ملغى') }}';
                        break;
                    default:
                        statusClass = 'text-secondary';
                        statusText = order.status || '{{ __('غير معروف') }}';
                }

                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td>${item.product_name || '{{ __('غير معروف') }}'}</td>
                            <td class="text-center">${item.quantity || 0}</td>
                            <td dir="ltr">${item.price || 0} ₪</td>
                            <td dir="ltr">${(item.quantity * item.price) || 0} ₪</td>
                        </tr>
                    `;
                });

                const discountRow = order.discount > 0 ? `
                    <tr>
                        <td colspan="3" class="text-end"><strong>{{ __('الخصم') }} (${order.coupon_code}):</strong></td>
                        <td dir="ltr">- ${order.discount} ₪</td>
                    </tr>` : '';

                const notesSection = order.notes ? `
                    <div class="order-notes mt-4">
                        <h5 class="fw-bold mb-2">{{ __('ملاحظات الطلب') }}</h5>
                        <p>${order.notes}</p>
                    </div>` : '';

                const html = `
                    <div class="order-header mb-5">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ __('معلومات الطلب') }}</h5>
                                <p><strong>{{ __('رقم الطلب') }}:</strong> ${order.code}</p>
                                <p><strong>{{ __('تاريخ الطلب') }}:</strong> ${orderDate}</p>
                                <p><strong>{{ __('حالة الطلب') }}:</strong> <span class="${statusClass}">${statusText}</span></p>
                            </div>
                            <div class="col-md-6">
                                <h5>{{ __('معلومات الدفع') }}</h5>
                                <p><strong>{{ __('طريقة الدفع') }}:</strong> {{ __('الدفع عند الاستلام') }}</p>
                                <p><strong>{{ __('المجموع') }}:</strong> ${order.total} ₪</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-customer mb-5">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ __('معلومات العميل') }}</h5>
                                <p><strong>{{ __('الاسم') }}:</strong> ${order.fname} ${order.lname}</p>
                                <p><strong>{{ __('البريد الإلكتروني') }}:</strong> ${order.email}</p>
                                <p><strong>{{ __('الهاتف') }}:</strong> ${order.phone}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>{{ __('عنوان الشحن') }}</h5>
                                <p>${order.address}, ${order.city}, ${order.postcode}</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-items mb-5">
                        <h5>{{ __('تفاصيل الطلب') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('المنتج') }}</th>
                                        <th class="text-center">{{ __('الكمية') }}</th>
                                        <th>{{ __('السعر') }}</th>
                                        <th>{{ __('المجموع') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>{{ __('المجموع الفرعي') }}:</strong></td>
                                        <td dir="ltr">${order.subtotal} ₪</td>
                                    </tr>
                                    ${discountRow}
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>{{ __('الضريبة') }}:</strong></td>
                                        <td dir="ltr">${order.tax} ₪</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>{{ __('المجموع الكلي') }}:</strong></td>
                                        <td dir="ltr">${order.total} ₪</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    ${notesSection}
                `;

                $('#orderTrackingResult .order-details-box').html(html);
            }
        });
    </script>
@endsection
