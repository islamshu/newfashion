@extends('layouts.master')
@section('title', __('عرض العميل'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('عرض العميل') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('العملاء') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('عرض العميل') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('تفاصيل العميل') }}</h4>
                    </div>

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="form-section mb-4">
                                <h5 class="form-section-title"><i class="ft-user"></i> {{ __('البيانات الأساسية') }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>{{ __('الاسم') }}:</strong> {{ $client->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>{{ __('رقم الجوال') }}:</strong> {{ $client->phone_number }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section mb-4">
                                <h5 class="form-section-title"><i class="ft-check-circle"></i> {{ __('التحقق') }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>{{ __('الحالة') }}:</strong>
                                            @if (empty($client->otp))
                                                <span class="badge badge-success">{{ __('تم التحقق') }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ __('غير محقق') }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="form-section mb-4">
                                <h5 class="form-section-title"><i class="ft-shopping-cart"></i> {{ __('طلبات العميل') }}
                                </h5>

                                @if ($client->orders->count())
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('المجموع') }}</th>
                                                    <th>{{ __('الحالة') }}</th>
                                                    <th>{{ __('التاريخ') }}</th>
                                                    <th>{{ __('الخيارات') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($client->orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ number_format($order->total, 2) }} ₪</td>
                                                        <td>
                                                            <span
                                                                class="badge 
                                                                    @switch($order->status)
                                                                        @case('pending') badge-warning  @break
                                                                        @case('processing') badge-primary  @break
                                                                        @case('completed') badge-success  @break
                                                                        @case('cancelled') badge-danger @break
                                                                        @default badge-secondary
                                                                    @endswitch">
                                                                {{ __($order->status == 'pending' ? 'قيد المعالجة' : ($order->status == 'processing' ? 'قيد التنفيذ' : ($order->status == 'completed' ? 'مكتمل' : ($order->status == 'cancelled' ? 'ملغي' : 'غير معروف'))) ) }}

                                                            </span>
                                                        </td>
                                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                        <td>
                                                            <a target="_blank" href="{{ route('orders.show', $order->id) }}"
                                                                class="btn btn-sm btn-info">
                                                                <i class="ft-eye"></i> {{ __('عرض') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">{{ __('لا توجد طلبات لهذا العميل.') }}</p>
                                @endif
                            </div>
                             <div class="form-actions text-center mt-3">
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-lg">
                                    <i class="ft-edit"></i> {{ __('تعديل') }}
                                </a>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
