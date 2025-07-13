@extends('layouts.frontend')
@section('title', __('التصنيفات'))

@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('جميع التصنيفات') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="category-section mt-110 mb-110">
        <div class="container">
            <div class="category-section-title mb-70 text-center">
                <p>{{ __('استكشف') }}</p>
                <h1>{{ __('التصنيفات') }}</h1>
            </div>

            <div class="row g-4 mb-70" id="categoryContainer">
                @include('frontend.partials.category-list', ['categories' => $categories])
            </div>

            <div class="load-more-btn text-center">
                <button id="loadMoreBtn" class="primary-btn1 hover-btn3">
                    {{ __('تحميل المزيد') }}
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentPage = 1;
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const categoryContainer = document.getElementById('categoryContainer');

        loadMoreBtn?.addEventListener('click', function() {
            currentPage++;

            fetch(`?page=${currentPage}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // نحول الـ HTML المستلم إلى عناصر DOM
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;

                    // نأخذ كل الأعمدة الجاهزة ونضيفها
                    tempDiv.querySelectorAll('.col-lg-3').forEach(el => {
                        categoryContainer.appendChild(el);
                    });

                    // إخفاء زر التحميل إذا لم تبق صفحات
                    if (!data.hasMore) {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error('خطأ في تحميل المزيد:', err);
                });
        });
    </script>

@endsection
