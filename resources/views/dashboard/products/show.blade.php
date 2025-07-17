@extends('layouts.master')
@section('style')
    <style>
        /* Card styling */
        .card {
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-header h4 {
            color: #333;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        /* Info sections */
        .info-section {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }

        .section-title {
            color: #3d4852;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .info-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1rem;
            color: #2d3748;
            margin-bottom: 15px;
            padding: 8px 0;
            border-bottom: 1px solid #edf2f7;
        }

        /* Status badges */
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-active {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge-inactive {
            background-color: #fed7d7;
            color: #822727;
        }

        .badge-featured {
            background-color: #bee3f8;
            color: #2a4365;
        }

        /* Image styling */
        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .image-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Variations table */
        .variation-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .variation-table th {
            background-color: #4299e1;
            color: white;
            padding: 12px 15px;
            text-align: center;
            font-weight: 500;
            border: none;
        }

        .variation-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
        }

        .variation-table tr:last-child td {
            border-bottom: none;
        }

        .variation-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .variation-table tr:hover {
            background-color: #ebf8ff;
        }

        /* تحسينات الخلايا الفارغة */
        .variation-table td.empty-value {
            color: #a0aec0;
            font-style: italic;
        }

        /* تحسينات للعرض على الأجهزة الصغيرة */
        @media (max-width: 768px) {
            .variation-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        /* Action buttons */
        .action-btns {
            margin-top: 2rem;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #4299e1;
            border-color: #4299e1;
            color: white;
        }

        .btn-primary:hover {
            background-color: #3182ce;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #718096;
            border-color: #718096;
            color: white;
        }

        .btn-danger {
            background-color: #e53e3e;
            border-color: #e53e3e;
            color: white;
        }
    </style>
@endsection
@section('title', __('عرض المنتج'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ __('عرض المنتج') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('عرض المنتج') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="product-show">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="ft-eye"></i> {{ __('بيانات المنتج') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <!-- المعلومات الأساسية -->
                                        <div class="info-section">
                                            <h5 class="section-title"><i class="ft-info"></i> {{ __('المعلومات الأساسية') }}
                                            </h5>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('اسم المنتج (عربي)') }}</label>
                                                        <p class="info-value">{{ $product->getTranslation('name', 'ar') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('اسم المنتج (عبري)') }}</label>
                                                        <p class="info-value" dir="rtl">
                                                            {{ $product->getTranslation('name', 'he') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('التصنيف') }}</label>
                                                        <p class="info-value">{{ $product->category->name }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('SKU') }}</label>
                                                        <p class="info-value">{{ $product->sku ?? '--' }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('السعر') }}</label>
                                                        <p class="info-value">{{ number_format($product->price, 2) }}
                                                            {{ __('ريال') }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('حالة المنتج') }}</label>
                                                        <p class="info-value">
                                                            <span
                                                                class="badge-status {{ $product->status ? 'badge-active' : 'badge-inactive' }}">
                                                                {{ $product->status ? __('نشط') : __('غير نشط') }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="info-group">
                                                <label class="info-label">{{ __('منتج مميز') }}</label>
                                                <p class="info-value">
                                                    <span
                                                        class="badge-status {{ $product->is_featured ? 'badge-featured' : '' }}">
                                                        {{ $product->is_featured ? __('مميز') : __('عادي') }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- الصور -->
                                        <div class="info-section">
                                            <h5 class="section-title"><i class="ft-image"></i> {{ __('صور المنتج') }}</h5>

                                            <div class="info-group">
                                                <label class="info-label">{{ __('الصور المصغرة') }}</label>
                                                <div class="image-container">
                                                    @forelse ($product->thumbnails as $thumb)
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('storage/' . $thumb->image) }}"
                                                                alt="صورة مصغرة">
                                                        </div>
                                                    @empty
                                                        <p>{{ __('لا توجد صور مصغرة') }}</p>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <div class="info-group">
                                                <label class="info-label">{{ __('الصور الإضافية') }}</label>
                                                <div class="image-container">
                                                    @forelse ($product->images as $image)
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('storage/' . $image->image) }}"
                                                                alt="صورة إضافية">
                                                        </div>
                                                    @empty
                                                        <p>{{ __('لا توجد صور إضافية') }}</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الوصف -->
                                        <div class="info-section">
                                            <h5 class="section-title"><i class="ft-align-left"></i> {{ __('الوصف') }}
                                            </h5>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('الوصف القصير (عربي)') }}</label>
                                                        <p class="info-value">
                                                            {{ $product->getTranslation('short_description', 'ar') ?? '--' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('الوصف القصير (عبري)') }}</label>
                                                        <p class="info-value" dir="rtl">
                                                            {{ $product->getTranslation('short_description', 'he') ?? '--' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('الوصف الكامل (عربي)') }}</label>
                                                        <p class="info-value">
                                                            {{ $product->getTranslation('description', 'ar') ?? '--' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="info-label">{{ __('الوصف الكامل (عبري)') }}</label>
                                                        <p class="info-value" dir="rtl">
                                                            {{ $product->getTranslation('description', 'he') ?? '--' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المتغيرات -->
                                        <div class="info-section">
                                            <h5 class="section-title"><i class="ft-layers"></i> {{ __('المتغيرات') }}</h5>

                                            @if ($product->variations->count() > 0)
                                                <div class="">
                                                    <table class="variation-table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('اللون') }}</th>
                                                                <th>{{ __('المقاس') }}</th>
                                                                <th>{{ __('الكمية المتاحة') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($product->variations as $variation)
                                                                <tr>
                                                                    <td>{{ $variation->color_id ? $variation->colorAttribute->value : '--' }}
                                                                    </td>
                                                                    <td>{{ $variation->size_id ? $variation->sizeAttribute->value : '--' }}
                                                                    </td>
                                                                    <td>{{ $variation->stock }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">{{ __('لا توجد متغيرات لهذا المنتج') }}</p>
                                            @endif
                                        </div>

                                        <!-- أزرار الإجراءات -->
                                        <div class="action-btns">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                                                <i class="ft-edit"></i> {{ __('تعديل') }}
                                            </a>
                                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                                <i class="ft-arrow-right"></i> {{ __('العودة للقائمة') }}
                                            </a>
                                        </div>
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
