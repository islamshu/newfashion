@extends('layouts.frontend')

@section('content')
    <div class="just-for-section mb-110">
        <img src="assets/img/home1/icon/vector-1.svg" alt="" class="vector1">
        <img src="assets/img/home1/icon/vector-2.svg" alt="" class="vector2">
        <div class="container">
            <form id="filterForm" class="mb-4">
                <div class="row align-items-center">

                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="name" class="form-label">{{ __('بحث بالاسم') }}</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="{{ __('اسم المنتج') }}" value="{{ request('name') }}">
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">{{ __('نطاق السعر') }}: <span id="priceRangeLabel"></span> ₪</label>
                        <div class="range-slider">
                            <input type="range" id="priceMin" name="price_min" min="0" max="1000"
                                value="{{ request('price_min', 0) }}" step="1">
                            <input type="range" id="priceMax" name="price_max" min="0" max="1000"
                                value="{{ request('price_max', 1000) }}" step="1">
                        </div>
                    </div>

                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('بحث') }}</button>
                    </div>

                </div>
            </form>




            <div class="row gy-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-all-products-tab" data-bs-toggle="pill"
                            data-bs-target="#v-all-products" type="button" role="tab" aria-controls="v-all-products"
                            aria-selected="true">
                            {{ __('جميع المنتجات') }}
                            <span>({{ $products->total() }})</span>
                        </button>
                        @foreach ($categories as $category)
                            <button class="nav-link" id="v-{{ Str::slug($category->name) }}-tab" data-bs-toggle="pill"
                                data-bs-target="#v-{{ Str::slug($category->name) }}" type="button" role="tab"
                                aria-controls="v-{{ Str::slug($category->name) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ __($category->name) }}
                                <span>({{ $category->products_count }})</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-all-products" role="tabpanel"
                            aria-labelledby="v-all-products-tab">
                            <div class="row gy-4" id="productContainer">
                                @include('frontend.partials.product-list', ['products' => $products])
                            </div>
                            <div class="text-center mt-4" id="loading" style="display:none">
                                <span>{{ __('تحميل المزيد...') }}</span>
                            </div>
                        </div>

                        @foreach ($categories as $category)
                            <div class="tab-pane fade" id="v-{{ Str::slug($category->name) }}" role="tabpanel"
                                aria-labelledby="v-{{ Str::slug($category->name) }}-tab">
                                <div class="row gy-4">
                                    @foreach ($category->products->take(6) as $product)
                                        <div class="col-xl-4 col-md-6">
                                            @include('frontend.partials.product-card', [
                                                'product' => $product,
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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

        // تحديث عرض النطاق بشكل ديناميكي
        function updatePriceLabel() {
            let min = parseInt(priceMin.value);
            let max = parseInt(priceMax.value);
            if (min > max) {
                // منع تجاوز القيم
                [min, max] = [max, min];
            }
            priceRangeLabel.textContent = min + ' - ' + max;
            priceMin.value = min;
            priceMax.value = max;
        }

        // عند تحميل الصفحة، تحديث العرض
        updatePriceLabel();

        // الحدث عند تحريك أحد السلايدرَين
        priceMin.addEventListener('input', updatePriceLabel);
        priceMax.addEventListener('input', updatePriceLabel);

        // AJAX عند الضغط على زر البحث
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams(formData);

            fetch(`{{ route('products.all') }}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    productContainer.innerHTML = html;
                });
        });
    </script>
    <script>
        let currentPage = 1;
        let isLoading = false;
        let hasMore = true;

        // تحميل المزيد عند التمرير
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
            formData.append('page', currentPage); // نمرر الصفحة
            const params = new URLSearchParams(formData);

            const loadingIndicator = document.getElementById('loading');
            loadingIndicator.style.display = 'block';

            fetch(`{{ route('products.all') }}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    if (html.trim() === '') {
                        hasMore = false; // لا توجد بيانات إضافية
                    } else {
                        productContainer.insertAdjacentHTML('beforeend', html);
                    }
                })
                .finally(() => {
                    isLoading = false;
                    loadingIndicator.style.display = 'none';
                });
        }

        // إعادة ضبط عند فلترة جديدة
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams(formData);
            currentPage = 1;
            hasMore = true;

            fetch(`{{ route('products.all') }}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    productContainer.innerHTML = html;
                });
        });
    </script>
@endsection
