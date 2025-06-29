@extends('layouts.master')
@section('title', __('كوبونات الخصم'))

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('كوبونات الخصم') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('كوبونات الخصم') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('إضافة كوبون جديد') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="filter-box mb-4">
                            <form id="filter-form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="{{ __('بحث بالكود') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" class="form-control">
                                            <option value="">{{ __('كل الحالات') }}</option>
                                            <option value="active">{{ __('نشط فقط') }}</option>
                                            <option value="inactive">{{ __('غير نشط') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">{{ __('بحث') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @include('dashboard.inc.alerts')

                        <div id="coupons-container">
                            @include('dashboard.coupons.partials.table', ['coupons' => $coupons])
                        </div>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
    <script>
        $(document).ready(function() {
            // تهيئة سلايدر السعر

            // إرسال نموذج البحث
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                fetchcategories();
            });

            // إعادة تعيين الفلترات
            $('#reset-filters').on('click', function() {
                $('#filter-form')[0].reset();
                fetchcategories();
            });

            // التنقل بين صفحات الجدول
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchcategories(page);
            });

            // تبديل عرض/إخفاء الفلتر
            $('.filter-toggle').on('click', function() {
                const filterBox = $(this).closest('.filter-box');
                filterBox.toggleClass('filter-expanded filter-collapsed');

                if (filterBox.hasClass('filter-expanded')) {
                    $(this).html('{{ __('إخفاء') }} <i class="ft-chevron-up"></i>');
                } else {
                    $(this).html('{{ __('عرض') }} <i class="ft-chevron-down"></i>');
                }
            });

            // دالة جلب التصنيفات
            function fetchcategories(page = 1) {
                $.ajax({
                    url: '{{ route('coupons.ajax') }}?page=' + page,
                    method: 'GET',
                    data: $('#filter-form').serialize(),
                    success: function(res) {
                        $('#coupons-container').html(res.html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection