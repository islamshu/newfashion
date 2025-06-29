@extends('layouts.master')
@section('title', __('إضافة كوبون جديد'))
@section('content')
@php
    $mode = isset($coupon) ? 'edit' : 'create';
@endphp
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">
                        {{ $mode == 'edit' ? __('تعديل كوبون') : __('إضافة كوبون جديد') }}
                    </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('coupons.index') }}">{{ __('كوبونات الخصم') }}</a></li>
                                <li class="breadcrumb-item active">
                                    {{ $mode == 'edit' ? __('تعديل كوبون') : __('إضافة كوبون جديد') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($coupon) ? __('تعديل') : __('إنشاء') }} {{ __('كوبون خصم') }}</h4>
                    </div>
                    @include('dashboard.inc.alerts')
                    <div class="card-body">
                        <form action="{{ isset($coupon) ? route('coupons.update', $coupon->id) : route('coupons.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($coupon))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('كود الكوبون') }} *</label>
                                        <input type="text" name="code" class="form-control"
                                            value="{{ old('code', $coupon->code ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('نوع الخصم') }} *</label>
                                        <select name="discount_type" class="form-control" required>
                                            <option value="percentage"
                                                {{ old('discount_type', $coupon->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>
                                                {{ __('نسبة مئوية') }} (%)
                                            </option>
                                            <option value="fixed_amount"
                                                {{ old('discount_type', $coupon->discount_type ?? '') == 'fixed_amount' ? 'selected' : '' }}>
                                                {{ __('مبلغ ثابت') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('قيمة الخصم') }} *</label>
                                        <input type="number" step="0.01" name="discount_value" class="form-control"
                                            value="{{ old('discount_value', $coupon->discount_value ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('الحد الأدنى للطلب') }} ({{ __('اختياري') }})</label>
                                        <input type="number" step="0.01" name="min_order_amount" class="form-control"
                                            value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('تاريخ البدء') }} *</label>
                                        <input type="date" name="start_date" class="form-control"
                                            value="{{ old('start_date', isset($coupon) ? $coupon->start_date->format('Y-m-d') : '') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('تاريخ الانتهاء') }} *</label>
                                        <input type="date" name="end_date" class="form-control"
                                            value="{{ old('end_date', isset($coupon) ? $coupon->end_date->format('Y-m-d') : '') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('حد الاستخدام') }} ({{ __('اختياري') }})</label>
                                        <input type="number" name="usage_limit" class="form-control"
                                            value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
                                        <small class="text-muted">{{ __('اتركه فارغاً ليكون غير محدود') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('الحالة') }}</label>

                                        <!-- Option 1: Switch Button -->
                                        <!-- الحل: أضف input hidden بالقيمة 0 قبل checkbox -->
                                        <input type="hidden" name="is_active" value="0">

                                        <label class="switch">
                                            <input type="checkbox" name="is_active" value="1"
                                                {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                            <span class="switch-label">
                                                {{ old('is_active', $coupon->is_active ?? true) ? __('مفعل') : __('غير مفعل') }}
                                            </span>
                                        </label>


                                        <!-- Option 2: Select Dropdown -->
                                        <!--
                                                <select name="is_active" class="form-control">
                                                    <option value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'selected' : '' }}>
                                                        {{ __('مفعل') }}
                                                    </option>
                                                    <option value="0" {{ !old('is_active', $coupon->is_active ?? true) ? 'selected' : '' }}>
                                                        {{ __('غير مفعل') }}
                                                    </option>
                                                </select>
                                                -->
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($coupon) ? __('تحديث') : __('إنشاء') }} {{ __('الكوبون') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        /* Switch Button Styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .switch-label {
            margin-right: 10px;
            font-weight: normal;
        }
    </style>
@endsection
