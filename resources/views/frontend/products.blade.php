@extends('layouts.frontend')
@section('title',__('المنتجات'))

@section('content')
    @php
        $activeCategoryId = request('category_id');
    @endphp
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('المنتجات') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="just-for-section mb-110">
        <div class="container">
            <form id="filterForm" class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="name" class="form-label">بحث بالاسم</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="اسم المنتج"
                            value="{{ request('name') }}">
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">نطاق السعر: <span id="priceRangeLabel"></span> ₪</label>
                        <div class="range-slider">
                            <input type="range" id="priceMin" name="price_min" min="0" max="1000"
                                value="{{ request('price_min', 0) }}" step="1">
                            <input type="range" id="priceMax" name="price_max" min="0" max="1000"
                                value="{{ request('price_max', 1000) }}" step="1">
                        </div>
                    </div>

                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                </div>

                {{-- إرفاق category_id إذا كان موجود --}}
                @if (request()->filled('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
            </form>

            <div class="row gy-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <button type="button"
                            class="nav-link category-tab {{ is_null($activeCategoryId) ? 'active' : '' }}"
                            data-category-id="">
                            جميع المنتجات
                            <span>({{ App\Models\Product::with(['category', 'images'])->active()->count() }})</span>
                        </button>

                        @foreach ($categories as $category)
                            <button type="button"
                                class="nav-link category-tab {{ $activeCategoryId == $category->id ? 'active' : '' }}"
                                data-category-id="{{ $category->id }}">
                                {{ $category->name }}
                                <span>({{ $category->products_count }})</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-9">
                    <div id="preload-loading" class="text-center my-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div id="productContainer">
                        @if ($products)
                            @include('frontend.partials.product-list', ['products' => $products])
                        @endif
                    </div>
                    <div class="text-center mt-4" id="loading" style="display:none">
                        <span>تحميل المزيد...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const priceRangeLabel = document.getElementById('priceRangeLabel');
    const filterForm = document.getElementById('filterForm');
    const productContainer = document.getElementById('productContainer');
    const preloadLoader = document.getElementById('preload-loading');
    const loadingIndicator = document.getElementById('loading');

    // تحديث نص نطاق السعر المعروض
    function updatePriceLabel() {
        let min = parseInt(priceMin.value);
        let max = parseInt(priceMax.value);
        if (min > max) [min, max] = [max, min];
        priceRangeLabel.textContent = min + ' - ' + max;
        priceMin.value = min;
        priceMax.value = max;
    }

    updatePriceLabel();
    priceMin.addEventListener('input', updatePriceLabel);
    priceMax.addEventListener('input', updatePriceLabel);

    // إرسال الفورم بالفلترة عبر AJAX
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        currentPage = 1;
        hasMore = true;

        const formData = new FormData(this);
        const params = new URLSearchParams(formData);

        preloadLoader.style.display = 'block';
        productContainer.style.display = 'none';

        fetch(`{{ route('products.all') }}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            productContainer.innerHTML = html;
        })
        .finally(() => {
            preloadLoader.style.display = 'none';
            productContainer.style.display = 'block';
        });
    });

    // التبديل بين تبويبات الفئات مع جلب المنتجات عبر AJAX
    document.querySelectorAll('.category-tab').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-tab').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const categoryId = this.dataset.categoryId;
            currentPage = 1;
            hasMore = true;

            const formData = new FormData(filterForm);
            if (categoryId) {
                formData.set('category_id', categoryId);
            } else {
                formData.delete('category_id');
            }

            const params = new URLSearchParams(formData);

            preloadLoader.style.display = 'block';
            productContainer.style.display = 'none';

            fetch(`{{ route('products.all') }}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                productContainer.innerHTML = html;

                // تحديث حقل category_id المخفي داخل الفورم
                let catInput = filterForm.querySelector('input[name="category_id"]');
                if (categoryId) {
                    if (!catInput) {
                        catInput = document.createElement('input');
                        catInput.type = 'hidden';
                        catInput.name = 'category_id';
                        filterForm.appendChild(catInput);
                    }
                    catInput.value = categoryId;
                } else {
                    catInput?.remove();
                }
            })
            .finally(() => {
                preloadLoader.style.display = 'none';
                productContainer.style.display = 'block';
            });
        });
    });

    // تحميل المزيد عند التمرير إلى الأسفل
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;

    window.addEventListener('scroll', function() {
        if (isLoading || !hasMore) return;
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 300) {
            loadMoreProducts();
        }
    });

    function loadMoreProducts() {
        isLoading = true;
        currentPage++;

        const formData = new FormData(filterForm);
        formData.append('page', currentPage);
        const params = new URLSearchParams(formData);

        loadingIndicator.style.display = 'block';

        fetch(`{{ route('products.all') }}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            if (html.trim() === '') {
                hasMore = false;
            } else {
                productContainer.insertAdjacentHTML('beforeend', html);
            }
        })
        .finally(() => {
            isLoading = false;
            loadingIndicator.style.display = 'none';
        });
    }

    // تحميل تلقائي عند فتح الصفحة بناءً على category_id في الرابط أو بدون فلترة
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('category_id');

        if (categoryId !== null) {
            const targetBtn = document.querySelector(`.category-tab[data-category-id="${categoryId}"]`);
            if (targetBtn) {
                setTimeout(() => targetBtn.click(), 100);
            } else {
                // إذا لم يجد الزر المطلوب، جلب كل المنتجات
                fetchAllProducts();
            }
        } else {
            fetchAllProducts();
        }

        function fetchAllProducts() {
            preloadLoader.style.display = 'block';
            productContainer.style.display = 'none';

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);

            fetch(`{{ route('products.all') }}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                productContainer.innerHTML = html;
            })
            .finally(() => {
                preloadLoader.style.display = 'none';
                productContainer.style.display = 'block';
            });
        }
    });
</script>
@endsection
