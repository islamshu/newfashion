@extends('layouts.master')
@section('title', __('العملاء'))

@section('style')
    <style>
        .badge-success {
            background-color: #28c76f;
            color: white;
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .badge-warning {
            background-color: #ff9f43;
            color: white;
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 5px;
        }
    </style>
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

        <style>.children-row-td ul li {
            border-bottom: 1px solid #eee;
        }

        .children-row-td ul li:last-child {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('قائمة العملاء') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('العملاء') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('كل العملاء') }}</h4>
                    </div>

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <!-- فلتر العملاء -->
                            <div class="filter-box filter-expanded">
                                <div class="filter-header">
                                    <h5 class="filter-title">
                                        <i class="ft-filter"></i> {{ __('تصفية العملاء') }}
                                    </h5>
                                    <button type="button" class="filter-toggle">
                                        {{ __('إخفاء') }} <i class="ft-chevron-up"></i>
                                    </button>
                                </div>

                                <div class="filter-body">
                                    <form id="filter-form" class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="filter-group">
                                                <label>{{ __('الاسم') }}</label>
                                                <input type="text" name="name" class="filter-control"
                                                    placeholder="ابحث باسم العميل">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <div class="filter-group">
                                                <label>{{ __('رقم الجوال') }}</label>
                                                <input type="text" name="phone_number" class="filter-control"
                                                    placeholder="ابحث برقم الجوال">
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-lg-3">
                                            <div class="filter-group">
                                                <label>{{ __('حالة التحقق') }}</label>
                                                <select name="verified" class="filter-control">
                                                    <option value="">{{ __('الكل') }}</option>
                                                    <option value="1">{{ __('تم التحقق') }}</option>
                                                    <option value="0">{{ __('غير محقق') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <div class="filter-group">
                                                <label>{{ __('حالة عميل') }}</label>
                                                <select name="is_active" class="filter-control">
                                                    <option value="">{{ __('الكل') }}</option>
                                                    <option value="1">{{ __('مفعل') }}</option>
                                                    <option value="0">{{ __('معطل') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3 pt-1">
                                            <div class="filter-actions">
                                                <button type="submit" class="filter-btn filter-btn-primary">
                                                    <i class="ft-search"></i> {{ __('بحث') }}
                                                </button>
                                                <button type="button" class="filter-btn filter-btn-secondary"
                                                    id="reset-filters">
                                                    <i class="ft-refresh-cw"></i> {{ __('إعادة تعيين') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- جدول العملاء -->
                            @include('dashboard.inc.alerts')

                            <div id="clients-container">
                                @include('dashboard.clients._table', ['clients' => $clients])
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function initSwitches() {
                // تدمير أي Switches موجودة سابقاً
                if (window.switches) {
                    window.switches.forEach(s => s.destroy());
                }
                window.switches = [];
                $('.js-switch').each(function() {
                    let switchery = new Switchery(this, {
                        size: 'small'
                    });
                    window.switches.push(switchery);
                });
            }
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                fetchClients();
            });

            $('#reset-filters').on('click', function() {
                $('#filter-form')[0].reset();
                fetchClients();
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchClients(page);
            });

            $('.filter-toggle').on('click', function() {
                const filterBox = $(this).closest('.filter-box');
                filterBox.toggleClass('filter-expanded filter-collapsed');

                if (filterBox.hasClass('filter-expanded')) {
                    $(this).html('{{ __('إخفاء') }} <i class="ft-chevron-up"></i>');
                } else {
                    $(this).html('{{ __('عرض') }} <i class="ft-chevron-down"></i>');
                }
            });

            function fetchClients(page = 1) {
                $.ajax({
                    url: '{{ route('clients.ajax') }}?page=' + page,
                    method: 'GET',
                    data: $('#filter-form').serialize(),
                    success: function(res) {
                        $('#clients-container').html(res.html);
                        initSwitches();

                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection
