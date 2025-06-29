@extends('layouts.master')

@section('style')
<style>
    .filter-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    
    .filter-group {
        margin-bottom: 1rem;
    }
    
    .filter-control {
        width: 100%;
        padding: 0.5rem 0.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background-color: #f8fafc;
        transition: all 0.3s;
    }
    
    .filter-btn {
        padding: 0.5rem 0.8rem;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 20px;
    }
</style>
@endsection

@section('title', __('إدارة التصنيفات'))

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="categories-section">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('قائمة التصنيفات') }}</h4>
                                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                                    <i class="ft-plus"></i> {{ __('إضافة تصنيف') }}
                                </a>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <!-- صندوق الفلتر -->
                                    <div class="filter-box">
                                        <form id="filter-form">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="filter-group">
                                                        <label>{{ __('بحث بالاسم') }}</label>
                                                        <input type="text" name="name" class="filter-control" placeholder="اسم التصنيف">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="filter-group">
                                                        <label>{{ __('الحالة') }}</label>
                                                        <select name="status" class="filter-control">
                                                            <option value="">{{ __('الكل') }}</option>
                                                            <option value="1">{{ __('مفعل') }}</option>
                                                            <option value="0">{{ __('غير مفعل') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="filter-group">
                                                        <label>{{ __('تاريخ الإنشاء') }}</label>
                                                        <input type="date" name="created_at" class="filter-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="filter-group" style="margin-top: 1.8rem;">
                                                        <button type="submit" class="filter-btn btn-primary">
                                                            <i class="la la-search"></i> {{ __('بحث') }}
                                                        </button>
                                                        <button type="button" id="reset-filters" class="filter-btn btn-secondary">
                                                            <i class="la la-undo"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- منطقة النتائج -->
                                    <div id="loading-spinner" class="loading-spinner">
                                        <i class="la la-spinner la-spin la-3x"></i>
                                    </div>
                                    
                                    <div id="categories-container">
                                        @include('dashboard.categories.partials.table', ['categories' => $categories])
                                    </div>
                                    
                                    <div id="pagination-container">
                                        {{ $categories->links('dashboard.categories.partials.pagination') }}
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

@section('scripts')
<script>
    $(document).ready(function() {
        // عند إرسال الفلتر
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            loadCategories();
        });

        // إعادة تعيين الفلتر
        $('#reset-filters').on('click', function() {
            $('#filter-form')[0].reset();
            loadCategories();
        });

        // عند النقر على الترقيم
        $(document).on('click', '.pagination a, .page-link', function(e) {
            e.preventDefault();
            let page = $(this).data('page') || $(this).attr('href').split('page=')[1];
            loadCategories(page);
        });

        // دالة جلب البيانات
        function loadCategories(page = 1) {
            $('#loading-spinner').show();
            $('#categories-container').hide();
            $('#pagination-container').hide();
            
            $.ajax({
                url: '{{ route("categories.index") }}?page=' + page,
                type: 'GET',
                data: $('#filter-form').serialize(),
                success: function(response) {
                    $('#categories-container').html(response.html).fadeIn();
                    $('#pagination-container').html(response.pagination).fadeIn();
                    $('#loading-spinner').hide();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    $('#loading-spinner').hide();
                    $('#categories-container').html('<div class="alert alert-danger">حدث خطأ أثناء جلب البيانات</div>').fadeIn();
                }
            });
        }
    });
</script>
@endsection