@extends('layouts.master')

@section('title', __('تفاصيل الطلب'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الطلبات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ __('الطلبات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">#{{ $order->code }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="printInvoice()" class="btn btn-dark">
                🖨️ {{ __('طباعة الفاتورة') }}
            </button>
            <div class="content-body">
                <section class="card">
                    <div class="card-body">

                        {{-- بيانات العميل والفاتورة --}}
                        <div class="row">
                            <!-- بيانات العميل -->
                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded bg-light">
                                    <h5 class="mb-3">{{ __('بيانات العميل') }}</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>{{ __('رقم الطلب:') }}</strong> {{ $order->code }}
                                        </li>
                                        <li><strong>{{ __('الاسم:') }}</strong> {{ $order->fname }} {{ $order->lname }}
                                        </li>
                                        <li><strong>{{ __('البريد الإلكتروني:') }}</strong> {{ $order->email }}</li>
                                        <li><strong>{{ __('الهاتف:') }}</strong> {{ $order->phone }}</li>
                                        <li><strong>{{ __('العنوان:') }}</strong> {{ $order->address }},
                                            {{ $order->city_data['name'][app()->getLocale()] }}</li>
                                        <li><strong>{{ __('ملاحظات:') }}</strong> {{ $order->notes ?? __('لا يوجد') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- تفاصيل الفاتورة -->
                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded bg-light">
                                    <h5 class="mb-3">{{ __('تفاصيل الفاتورة') }}</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>{{ __('الإجمالي قبل الخصم:') }}</strong>
                                            {{ number_format($order->subtotal, 2) }} ₪</li>
                                        @if($order->city_data && isset($order->city_data['delivery_fee']))
                                            <li><strong>{{ __('سعر التوصيل:') }}</strong> {{ number_format($order->city_data['delivery_fee'], 2) }} ₪</li>
                                        @endif
                                        <li><strong>{{ __('الخصم:') }}</strong> {{ number_format($order->discount, 2) }}
                                            ₪</li>
                                            
                                        <li><strong>{{ __('كود الكوبون:') }}</strong>
                                            {{ $order->coupon_code ?? __('لا يوجد') }}</li>
                                        <li><strong>{{ __('الإجمالي النهائي:') }}</strong> <span
                                                class="text-success">{{ number_format($order->total, 2) }}
                                                ₪</span></li>
                                        <li>
                                            <strong>{{ __('الحالة:') }}</strong>
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <i id="order-status-icon"
                                                    class="la {{ match ($order->status) {
                                                        'pending' => 'la-clock text-warning',
                                                        'processing' => 'la-cogs text-primary',
                                                        'completed' => 'la-check-circle text-success',
                                                        'cancelled' => 'la-times-circle text-danger',
                                                        default => 'la-question-circle text-muted',
                                                    } }}"></i>

                                                <select id="order-status-select" class="form-control form-control-sm"
                                                    style="width: 180px;" data-id="{{ $order->id }}">
                                                    <option value="pending"
                                                        {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                        {{ __('قيد المعالجة') }}
                                                    </option>
                                                    <option value="processing"
                                                        {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                        {{ __('قيد التنفيذ') }}
                                                    </option>
                                                    <option value="completed"
                                                        {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                        {{ __('مكتمل') }}
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                        {{ __('ملغي') }}</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- جدول عناصر الطلب --}}
                        <h5 class="mb-3">{{ __('عناصر الطلب') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('اسم المنتج') }}</th>
                                        <th>{{ __('اللون') }}</th>
                                        <th>{{ __('المقاس') }}</th>
                                        <th>{{ __('الكمية') }}</th>
                                        <th>{{ __('السعر') }}</th>
                                        <th>{{ __('الإجمالي') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                @if ($item->image)
                                                    <img src="{{ asset('storage/' . $item->image) }}" width="50"
                                                        height="50" class="rounded" alt="product">
                                                @else
                                                    <span>{{ __('لا يوجد') }}</span>
                                                @endif
                                            </td>
                                            <td><a
                                                    href="{{ route('products.show', $item->product_id) }}">{{ $item->product_name }}</a>
                                            </td>
                                            <td>
                                                @if ($item->colorAttr && $item->colorAttr->code)
                                                    <span
                                                        style="display:inline-block; width:20px; height:20px; border-radius:4px; background-color:{{ $item->colorAttr->code }}; border:1px solid #ccc;"></span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->sizeAttr->value ?? '-' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 2) }} ₪</td>
                                            <td>{{ number_format($item->total, 2) }} ₪</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">
                            <i class="ft-arrow-right"></i> {{ __('رجوع') }}
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="order-details-box p-5 rounded-4 shadow-lg bg-white border border-gray-200" style="display: none">
        @php
            $statusMap = [
                'pending' => ['text-warning', __('قيد المعالجة')],
                'processing' => ['text-info', __('قيد التنفيذ')],
                'completed' => ['text-success', __('مكتمل')],
                'cancelled' => ['text-danger', __('ملغى')],
            ];
            [$statusClass, $statusText] = $statusMap[$order->status] ?? [
                'text-secondary',
                $order->status ?? __('غير معروف'),
            ];
        @endphp

        <div class="order-header mb-5">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ __('معلومات الطلب') }}</h5>
                    <p><strong>{{ __('رقم الطلب') }}:</strong> {{ $order->code }}</p>
                    <p><strong>{{ __('تاريخ الطلب') }}:</strong>
                        {{ $order->created_at->format('Y-m-d') }}</p>
                    <p><strong>{{ __('حالة الطلب') }}:</strong> <span
                            class="{{ $statusClass }}">{{ $statusText }}</span></p>
                </div>
                <div class="col-md-6">
                    <h5>{{ __('معلومات الدفع') }}</h5>
                    <p><strong>{{ __('طريقة الدفع') }}:</strong> {{ __('الدفع عند الاستلام') }}</p>
                    <p><strong>{{ __('المجموع') }}:</strong> {{ $order->total }} ₪</p>
                </div>
            </div>
        </div>

        <div class="order-customer mb-5">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ __('معلومات العميل') }}</h5>
                    <p><strong>{{ __('الاسم') }}:</strong> {{ $order->fname }} {{ $order->lname }}
                    </p>
                    <p><strong>{{ __('البريد الإلكتروني') }}:</strong> {{ $order->email }}</p>
                    <p><strong>{{ __('الهاتف') }}:</strong> {{ $order->phone }}</p>
                </div>
                <div class="col-md-6">
                    <h5>{{ __('عنوان الشحن') }}</h5>
                    <p>{{ $order->address }}, {{ $order->city }}, {{ $order->postcode }}</p>
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
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name ?? '---' }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td dir="ltr">{{ $item->price }} ₪</td>
                                <td dir="ltr">{{ $item->price * $item->quantity }} ₪</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end">
                                <strong>{{ __('المجموع الفرعي') }}:</strong>
                            </td>
                            <td dir="ltr">{{ $order->subtotal }} ₪</td>
                        </tr>
                        @if ($order->discount > 0)
                            <tr>
                                <td colspan="3" class="text-end"><strong>{{ __('الخصم') }}
                                        ({{ $order->coupon_code }}):</strong></td>
                                <td dir="ltr">- {{ $order->discount }} ₪</td>
                            </tr>
                        @endif
                        
                        <tr>
                            <td colspan="3" class="text-end">
                                <strong>{{ __('المجموع الكلي') }}:</strong>
                            </td>
                            <td dir="ltr">{{ $order->total }} ₪</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if ($order->notes)
            <div class="order-notes mt-4">
                <h5 class="fw-bold mb-2">{{ __('ملاحظات الطلب') }}</h5>
                <p>{{ $order->notes }}</p>
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#order-status-select').on('change', function() {
                const orderId = $(this).data('id');
                const status = $(this).val();

                const route = "{{ route('orders.change_status', '__id__') }}".replace('__id__', orderId);

                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId,
                        status: status,
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التحديث',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // تحديث الأيقونة
                        const iconMap = {
                            pending: 'la-clock text-warning',
                            processing: 'la-cogs text-primary',
                            completed: 'la-check-circle text-success',
                            cancelled: 'la-times-circle text-danger'
                        };
                        $('#order-status-icon').attr('class', 'la ' + iconMap[status]);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: xhr.responseJSON?.message || 'حدث خطأ أثناء التحديث'
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function printInvoice() {
            // استهداف صندوق تفاصيل الطلب فقط
            const printContents = document.querySelector('.order-details-box').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = `
            <html>
            <head>
                <title>{{ __('فاتورة الطلب') }}</title>
                <style>
                    body { direction: rtl; font-family: Arial, sans-serif; color: #000; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; }
                    th { background-color: #f2f2f2; }
                    h5 { margin-top: 20px; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
            </html>
        `;

            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload(); // لإعادة الصفحة كما كانت
        }
    </script>
@endsection
