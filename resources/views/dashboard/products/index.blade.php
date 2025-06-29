@extends('layouts.master')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css" rel="stylesheet">
    <style>
        /* تنسيقات عامة للفلتر */
        .filter-box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 1.2rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #334155;
            margin: 0;
        }
        
        .filter-toggle {
            background: none;
            border: none;
            color: #64748b;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        
        .filter-toggle i {
            margin-left: 5px;
            font-size: 0.9rem;
            transition: transform 0.3s;
        }
        
        .filter-toggle.collapsed i {
            transform: rotate(180deg);
        }
        
        /* تنسيقات حقول الإدخال */
        .filter-group {
            margin-bottom: 1rem;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 500;
            color: #475569;
            font-size: 0.85rem;
        }
        
        .filter-control {
            width: 100%;
            padding: 0.5rem 0.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background-color: #f8fafc;
            transition: all 0.3s;
            font-size: 0.85rem;
        }
        
        .filter-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
            background-color: #fff;
        }
        
        /* تنسيقات السلايدر المصغر */
        .price-slider-container {
            padding: 0.8rem 0.4rem;
        }
        
        #price-slider {
            margin-top: 1rem;
            height: 4px;
        }
        
        #price-slider .noUi-connect {
            background-color: #3b82f6;
        }
        
        #price-slider .noUi-base {
            background-color: #e2e8f0;
            border-radius: 2px;
        }
        
        #price-slider .noUi-handle {
            width: 16px;
            height: 16px;
            top: -6px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #3b82f6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .price-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 0.4rem;
            font-size: 0.8rem;
            color: #64748b;
        }
        
        /* تنسيقات الأزرار المصغرة */
        .filter-actions {
            display: flex;
            gap: 0.8rem;
            margin-top: 1rem;
        }
        
        .filter-btn {
            flex: 1;
            padding: 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }
        
        .filter-btn i {
            font-size: 0.9rem;
            margin-left: 0.3rem;
        }
        
        .filter-btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .filter-btn-primary:hover {
            background-color: #2563eb;
        }
        
        .filter-btn-secondary {
            background-color: #f1f5f9;
            color: #64748b;
        }
        
        .filter-btn-secondary:hover {
            background-color: #e2e8f0;
        }
        
        /* تنسيقات للواجهة RTL */
        [dir="rtl"] .filter-toggle i {
            margin-left: 0;
            margin-right: 5px;
        }
        
        [dir="rtl"] #price-slider .noUi-origin {
            right: auto !important;
            left: 0 !important;
        }
        
        [dir="rtl"] .filter-btn i {
            margin-left: 0;
            margin-right: 0.3rem;
        }
    </style>
@endsection
@section('title', __('قائمة المنتجات'))
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('قائمة المنتجات') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('المنتجات') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('جميع المنتجات') }}</h4>
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm float-right">
                            <i class="ft-plus"></i> {{ __('إضافة جديد') }}
                        </a>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <!-- صندوق الفلتر المحسن -->
                            <div class="filter-box filter-expanded">
                                <div class="filter-header">
                                    <h5 class="filter-title">
                                        <i class="ft-filter"></i> {{ __('تصفية المنتجات') }}
                                    </h5>
                                    <button type="button" class="filter-toggle">
                                        {{ __('إخفاء') }} <i class="ft-chevron-up"></i>
                                    </button>
                                </div>
                                
                                <div class="filter-body">
                                    <form id="filter-form" class="row">
                                        <!-- حقل الاسم -->
                                        <div class="col-md-6 col-lg-3">
                                            <div class="filter-group">
                                                <label for="filter-name">{{ __('اسم المنتج') }}</label>
                                                <input type="text" name="name" id="filter-name" class="filter-control" 
                                                       placeholder="{{ __('ابحث باسم المنتج') }}">
                                            </div>
                                        </div>
                                        
                                        <!-- حقل الحالة -->
                                        <div class="col-md-6 col-lg-3">
                                            <div class="filter-group">
                                                <label for="filter-status">{{ __('حالة المنتج') }}</label>
                                                <select name="status" id="filter-status" class="filter-control">
                                                    <option value="">{{ __('الكل') }}</option>
                                                    <option value="1">{{ __('نشط') }}</option>
                                                    <option value="0">{{ __('غير نشط') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- حقل التصنيف -->
                                        <div class="col-md-6 col-lg-3">
                                            <div class="filter-group">
                                                <label for="category_id">{{ __('التصنيف') }}</label>
                                                <select name="category_id" id="category_id" class="filter-control">
                                                    <option value="">{{ __('الكل') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- حقل التاريخ -->
                                        <div class="col-md-6 col-lg-3">
                                            <div class="filter-group">
                                                <label for="filter-date">{{ __('تاريخ الإنشاء') }}</label>
                                                <input type="date" name="created_at" id="filter-date" class="filter-control">
                                            </div>
                                        </div>
                                        
                                        <!-- سلايدر السعر -->
                                        <div class="col-12">
                                            <div class="filter-group price-slider-container">
                                                <label>{{ __('نطاق السعر') }}</label>
                                                <div id="price-slider"></div>
                                                <div class="price-labels">
                                                    <span>{{ __('من') }}: <strong id="price-min-label">0</strong> {{ __('ر.س') }}</span>
                                                    <span>{{ __('إلى') }}: <strong id="price-max-label">1000</strong> {{ __('ر.س') }}</span>
                                                </div>
                                                <input type="hidden" name="price_min" id="price_min">
                                                <input type="hidden" name="price_max" id="price_max">
                                            </div>
                                        </div>
                                        
                                        <!-- أزرار الفلتر -->
                                        <div class="col-12">
                    <div class="filter-actions">
                        <button type="submit" class="filter-btn filter-btn-primary">
                            <i class="ft-search"></i> {{ __('بحث') }}
                        </button>
                        <button type="button" class="filter-btn filter-btn-secondary" id="reset-filters">
                            <i class="ft-refresh-cw"></i> {{ __('إعادة تعيين') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
                            <!-- جدول المنتجات -->
                            <div id="products-container">
                                @include('dashboard.products._table', ['products' => $products])
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
    <script>
        $(document).ready(function() {
            // تهيئة سلايدر السعر
            const priceSlider = document.getElementById('price-slider');
            noUiSlider.create(priceSlider, {
                start: [0, 1000],
                connect: true,
                direction: 'rtl',
                range: {
                    'min': 0,
                    'max': 1000
                },
                step: 10,
                tooltips: [true, true],
                format: {
                    to: value => Math.round(value),
                    from: value => Number(value)
                }
            });

            // تحديث قيم السلايدر
            priceSlider.noUiSlider.on('update', function(values) {
                $('#price_min').val(values[0]);
                $('#price_max').val(values[1]);
                $('#price-min-label').text(values[0]);
                $('#price-max-label').text(values[1]);
            });

            // إرسال نموذج البحث
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                fetchProducts();
            });

            // إعادة تعيين الفلترات
            $('#reset-filters').on('click', function() {
                $('#filter-form')[0].reset();
                priceSlider.noUiSlider.set([0, 1000]);
                fetchProducts();
            });

            // التنقل بين صفحات الجدول
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchProducts(page);
            });

            // تبديل عرض/إخفاء الفلتر
            $('.filter-toggle').on('click', function() {
                const filterBox = $(this).closest('.filter-box');
                filterBox.toggleClass('filter-expanded filter-collapsed');
                
                if (filterBox.hasClass('filter-expanded')) {
                    $(this).html('{{ __("إخفاء") }} <i class="ft-chevron-up"></i>');
                } else {
                    $(this).html('{{ __("عرض") }} <i class="ft-chevron-down"></i>');
                }
            });

            // دالة جلب المنتجات
            function fetchProducts(page = 1) {
                $.ajax({
                    url: '{{ route('products.ajax') }}?page=' + page,
                    method: 'GET',
                    data: $('#filter-form').serialize(),
                    success: function(res) {
                        $('#products-container').html(res.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection