@extends('layouts.frontend')
@section('title', __('الطلب : ') . ($order?->code ?? ''))

@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('الطلب : ') . ($order?->code ?? '') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="order-tracking-section mt-110 mb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-end mb-3">
                        <button onclick="printInvoice()" class="btn btn-dark">
                            🖨️ {{ __('طباعة الفاتورة') }}
                        </button>
                    </div>

                    @if ($order)
                        <div class="order-details-box p-5 rounded-4 shadow-lg bg-white border border-gray-200">
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
                                                    <strong>{{ __('المجموع الفرعي') }}:</strong></td>
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
                                                <td colspan="3" class="text-end"><strong>{{ __('الضريبة') }}:</strong>
                                                </td>
                                                <td dir="ltr">{{ $order->tax }} ₪</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">
                                                    <strong>{{ __('المجموع الكلي') }}:</strong></td>
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
                    @else
                        <div class="alert alert-warning text-center p-5">
                            {{ __('يرجى إدخال رقم الطلب لعرض التفاصيل') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-tracking-section {
            position: relative;
            background: url('{{ Storage::url(get_general_value('track_image_cover')) }}') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            background-color: #f9f9f9;
            z-index: 1;
            padding: 80px 0;
        }

        .text-warning {
            color: #f59e0b !important;
        }

        .text-info {
            color: #0d6efd !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }
    </style>
@endsection
@section('scripts')
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
