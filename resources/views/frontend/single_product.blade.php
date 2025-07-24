@extends('layouts.frontend')
@section('title', $product->name)

@section('content')
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb Section section -->

    <!-- Start Shop Details top section -->
    <div class="shop-details-top-section mt-110 mb-110">
        <div class="container-xl container-fluid-lg container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="shop-details-img style-4">

                        {{-- Thumbnail Navigation --}}
                        <div class="nav nav-pills order-xl-1 order-lg-2 order-sm-1 order-2" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach ($product->images as $index => $image)
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="v-pills-img{{ $index + 1 }}-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-img{{ $index + 1 }}" type="button" role="tab"
                                    aria-controls="v-pills-img{{ $index + 1 }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    <img src="{{ Storage::url($image->image) }}" alt="thumb-{{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>

                        {{-- Main Image Preview --}}
                        <div class="tab-content order-xl-2 order-lg-1 order-sm-2 order-1" id="v-pills-tabContent">
                            @foreach ($product->images as $index => $image)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="v-pills-img{{ $index + 1 }}" role="tabpanel"
                                    aria-labelledby="v-pills-img{{ $index + 1 }}-tab">
                                    <div class="shop-details-tab-img product-img--main" data-scale="1.4"
                                        data-image="{{ Storage::url($image->image) }}">
                                        <img src="{{ Storage::url($image->image) }}" alt="image-{{ $index + 1 }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shop-details-content">
                        <h1>{{ $product->name }}</h1>
                        <div class="rating-review">
                            <div class="rating">
                                <div class="star">
                                    @php
                                        // جلب القيمة الوهمية (مثلاً من المنتج)
                                        $fakeRatingEnabled = $product->fake_rating_enabled ?? false;
                                        $fakeRatingValue = $product->fake_rating_value ?? 0;
                                        // قيمة التقييم الحقيقية (مثال - يمكن تغييره حسب بياناتك)
                                        $realRatingValue = $product->reviews()->avg('rating') ?? 0;
                                        $ratingCount = $product->reviews()->count() ?? 0;

                                        // التقييم الذي سيتم عرضه (وهمي أو حقيقي)
                                        $displayRating = $fakeRatingEnabled ? $fakeRatingValue : $realRatingValue;

                                        // تحويل الرقم إلى نجوم كاملة/نصف/فارغة
                                        $fullStars = floor($displayRating);
                                        $halfStar = $displayRating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                                    @endphp

                                    {{-- عرض النجوم كاملة --}}
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor

                                    {{-- عرض نصف نجمة إذا وجدت --}}
                                    @if ($halfStar)
                                        <i class="bi bi-star-half"></i>
                                    @endif

                                    {{-- عرض النجوم الفارغة --}}
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="bi bi-star"></i>
                                    @endfor
                                </div>

                                {{-- عرض عدد التقييمات --}}
                                <p>
                                    @if ($fakeRatingEnabled)
                                        ({{ number_format($fakeRatingValue, 1) }})
                                    @else
                                        ({{ $ratingCount }})
                                    @endif
                                </p>
                            </div>
                        </div>

                        <p>{!! $product->short_description !!}</p>
                        <div class="price-area">
                            <p class="price">{{ $product->price }} ₪</p>
                        </div>
                        <p id="stock-display" class="stock-available text-success mt-2"
                            data-stock-label="{{ __('الكمية المتوفرة') }}"></p>

                        <div class="quantity-color-area product-box">

                            <div class="quantity-color">
                                <h6 class="widget-title">{{ __('الكمية') }}</h6>
                                <div class="quantity-counter">
                                    <button type="button" class="quantity-btn minus"><i class='bx bx-minus'></i></button>
                                    <input name="quantity" type="number" min="1" max="100"
                                        class="quantity-input" value="1">
                                    <button type="button" class="quantity-btn plus"><i class='bx bx-plus'></i></button>
                                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                                </div>
                            </div>

                            @php $firstColorChecked = false; @endphp
                            @if ($variations->whereNotNull('color_id')->count() > 0)
                                <div class="quantity-color">
                                    <h6 class="widget-title">{{ __('اللون') }}</h6>
                                    <ul class="color-list">
                                        @foreach ($colors as $color)
                                            @if ($variations->where('color_id', $color->id)->count() > 0)
                                                <li>
                                                    <input type="radio" name="color_id" id="color-{{ $color->id }}"
                                                        value="{{ $color->id }}" class="color-radio" hidden
                                                        @if (!$firstColorChecked) checked @php $firstColorChecked = true; @endphp @endif>
                                                    <label for="color-{{ $color->id }}"
                                                        style="background: {{ $color->code }}"
                                                        class="color-option"></label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @php $firstSizeChecked = false; @endphp
                            @if ($variations->whereNotNull('size_id')->count() > 0)
                                <div class="quantity-color">
                                    <h6 class="widget-title">{{ __('المقاس') }}</h6>
                                    <ul class="size-list">
                                        @foreach ($sizes as $size)
                                            @if ($variations->where('size_id', $size->id)->count() > 0)
                                                <li>
                                                    <input type="radio" name="size_id" id="size-{{ $size->id }}"
                                                        value="{{ $size->id }}" class="size-radio" hidden
                                                        @if (!$firstSizeChecked) checked @php $firstSizeChecked = true; @endphp @endif>
                                                    <label for="size-{{ $size->id }}"
                                                        class="size-option">{{ $size->value }}</label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                        <div class="shop-details-btn">
                            @if ($variations->isEmpty())
                                <div class="out-of-stock">
                                    <span>{{ __('نفذ من المخزون') }}</span>
                                </div>
                            @else
                                <a href="{{ route('checkout') }}"
                                    class="primary-btn1 hover-btn3">{{ __('اشتري الآن') }}</a>
                                <a id="add-to-cart-btn"
                                    class="primary-btn1 style-3 hover-btn4">{{ __('أضف الى السلة') }}</a>
                            @endif
                        </div>

                        <div class="payment-method">
                            <h6>{{ __('عملية دفع آمنة مضمونة') }}</h6>
                            <ul class="payment-card-list">
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img1.svg') }}"
                                        alt=""></li>
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img2.svg') }}"
                                        alt=""></li>
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img3.svg') }}"
                                        alt=""></li>
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img4.svg') }}"
                                        alt=""></li>
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img5.svg') }}"
                                        alt=""></li>
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img6.svg') }}"
                                        alt=""></li>
                                <li><img src="{{ asset('front/assets/img/inner-page/payment-img7.svg') }}"
                                        alt=""></li>
                            </ul>
                        </div>

                        <ul class="product-shipping-delivers">
                            <li class="product-shipping">
                                <i class="fas fa-shipping-fast"></i>
                                {{ __('شحن مجاني لجميع أنحاء العالم للطلبات فوق 100 دولار') }}
                            </li>
                            <li class="product-delivers">
                                <i class="fas fa-truck"></i>
                                <p>{{ __('مدة التوصيل: من 3 إلى 7 أيام عمل ') }}<a
                                         href="{{route('page','syas-alshhn-oalastragaa')}}>{{ __('شحن وإرجاع') }}</a></p>
                            </li>
                        </ul>
                        <div class="compare-wishlist-area">
                            <ul>

                                <li>
                                    <button class="add-to-wishlist btn {{ $product->isInWishlist() ? 'active' : '' }}"
                                        data-product-id="{{ $product->id }}" title="{{ __('أضف إلى المفضلة') }}">
                                        <span>
                                            <svg width="11" height="11" viewBox="0 0 18 18"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_168_378)">
                                                    <path
                                                        d="M16.528 2.20919C16.0674 1.71411 15.5099 1.31906 14.8902 1.04859C14.2704 0.778112 13.6017 0.637996 12.9255 0.636946C12.2487 0.637725 11.5794 0.777639 10.959 1.048C10.3386 1.31835 9.78042 1.71338 9.31911 2.20854L9.00132 2.54436L8.68352 2.20854C6.83326 0.217151 3.71893 0.102789 1.72758 1.95306C1.63932 2.03507 1.5541 2.12029 1.47209 2.20854C-0.490696 4.32565 -0.490696 7.59753 1.47209 9.71463L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1868C9.45217 17.1788 9.46039 17.1706 9.46838 17.1622L16.528 9.71463C18.4907 7.59776 18.4907 4.32606 16.528 2.20919ZM15.5971 8.82879H15.5965L9.00132 15.7849L2.40553 8.82879C0.90608 7.21113 0.90608 4.7114 2.40553 3.09374C3.76722 1.61789 6.06755 1.52535 7.5434 2.88703C7.61505 2.95314 7.68401 3.0221 7.75012 3.09374L8.5343 3.92104C8.79272 4.17781 9.20995 4.17781 9.46838 3.92104L10.2526 3.09438C11.6142 1.61853 13.9146 1.52599 15.3904 2.88767C15.4621 2.95378 15.531 3.02274 15.5971 3.09438C17.1096 4.71461 17.1207 7.2189 15.5971 8.82879Z" />
                                                </g>
                                            </svg>
                                        </span>
                                        {{ __('اضف الى المفضلة') }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Product Reviews Section -->
    <div class="product-reviews-section mb-110">
        <div class="container">
            <div class="review-area">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="comment-section style-2 p-4 border rounded shadow-sm bg-white">

                            <!-- عنوان التقييم وزر الإضافة -->
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                <h4 class="mb-0">
                                    {{ __('تقييمات العملاء') }} ({{ $product->reviews->count() }})
                                </h4>

                                @auth('client')
                                    @if (auth('client')->user()->hasPurchasedProduct($product->id))
                                        @if (!auth('client')->user()->hasReviewedProduct($product->id))
                                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addReviewModal">
                                                {{ __('أضف تقييمك') }}
                                            </button>
                                        @else
                                            <small class="text-success">{{ __('لقد قمت بتقييم هذا المنتج بالفعل') }}</small>
                                        @endif
                                    @else
                                        <small class="text-muted">{{ __('يمكنك إضافة تقييم بعد شراء هذا المنتج') }}</small>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">
                                        {{ __('سجل الدخول لإضافة تقييم') }}
                                    </a>
                                @endauth
                            </div>

                            <!-- التقييمات أو رسالة لا توجد تقييمات -->
                            @if ($product->reviews->isEmpty())
                                <div class="alert alert-info">
                                    {{ __('لا توجد تقييمات لهذا المنتج بعد. كن أول من يقيم!') }}
                                </div>
                            @else
                                <ul class="list-unstyled">
                                    @foreach ($product->reviews as $review)
                                        <li class="mb-4 border-bottom pb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-1">
                                                    {{ $review->client->name }}
                                                    <small class="text-muted ms-2">
                                                        {{ $review->created_at->format('Y-m-d') }}
                                                    </small>
                                                </h6>
                                                <ul class="list-inline m-0 small text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li class="list-inline-item">
                                                            <i
                                                                class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                                        </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <p class="mt-2 mb-0 text-muted">{{ $review->review }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Product Reviews Section -->

    <!-- Review Modal -->
    <div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('أضف تقييمك') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3">
                            <label class="form-label">{{ __('التقييم') }}</label>
                            <div class="rating-input">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating"
                                        value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" title="{{ $i }} نجوم"><i
                                            class="bi bi-star-fill"></i></label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">{{ __('التعليق') }}</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="primary-btn1 style-2"
                            data-bs-dismiss="modal">{{ __('إغلاق') }}</button>
                        <button type="submit" id="submitReview" class="primary-btn1">
                            <span class="btn-text">{{ __('إرسال التقييم') }}</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="newest-product-section mb-110">
        <div class="container">
            <div class="section-title2 style-2">
                <h3>{{ __('منتجات ذات صلة') }}</h3>
                <div class="slider-btn">
                    <div class="prev-btn" tabindex="0" role="button" aria-label="Previous slide"
                        aria-controls="swiper-wrapper-4dc9910387c72ca0">
                        <i class="bi bi-chevron-left"></i>
                    </div>
                    <div class="next-btn" tabindex="0" role="button" aria-label="Next slide"
                        aria-controls="swiper-wrapper-4dc9910387c72ca0">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div
                        class="swiper newest-slider swiper-initialized swiper-horizontal swiper-pointer-events swiper-rtl">
                        <div class="swiper-wrapper">
                            @foreach ($relatedProducts as $relatedProduct)
                                <div class="swiper-slide">
                                    @include('frontend.partials.product-card', [
                                        'product' => $relatedProduct,
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        function initializeProductModalScripts() {
            const productId = $('#product_id').val();
            let currentStock = document.getElementById('stock-display');

            const $colorInputs = $('input[name="color_id"]');
            const $sizeContainer = $('.size-list');
            const $stockLabel = $('.stock-available');
            const $quantityInput = $('.quantity-input');

            function fetchSizes(colorId = null) {
                $sizeContainer.html(`
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">جارٍ التحميل...</span>
                </div> {{ __('جاري التحميل ...') }}
            `);

                $.get('/get-sizes', {
                    product_id: productId,
                    color_id: colorId
                }, function(sizes) {
                    let html = '';
                    sizes.forEach((size, index) => {
                        const isChecked = index === 0 ? 'checked' : '';
                        html += `
                        <li>
                            <input type="radio" name="size_id" id="size-${size.id}" value="${size.id}" class="size-radio" hidden ${isChecked}>
                            <label for="size-${size.id}" class="size-option">${size.value}</label>
                        </li>
                    `;
                    });

                    $sizeContainer.html(html);

                    // بعد تحميل الأحجام وتحديد أول واحدة، احضر المخزون تلقائيًا
                    const selectedSizeId = sizes.length > 0 ? sizes[0].id : null;
                    const selectedColorId = $('input[name="color_id"]:checked').val() || null;
                    fetchStock(productId, selectedColorId, selectedSizeId);
                });
            }

            function fetchStock(productId, colorId = null, sizeId = null) {
                // 🌀 عرض لودر
                $stockLabel.html(`
                <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                    <span class="visually-hidden">جارٍ التحميل...</span>
                </div> {{ __('جاري التحميل ...') }}
            `);

                $.get('/get-stock', {
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId
                }, function(response) {
                    currentStock = response.stock || 1;

                    let label = $stockLabel.data('stock-label');
                    $stockLabel.text(label + ': ' + currentStock);
                    $quantityInput.data('max-stock', currentStock);
                });
            }

            // عرض الأحجام إذا لم توجد ألوان
            if ($colorInputs.length === 0) {
                fetchSizes();
            } else {
                // عرض الأحجام حسب أول لون محدد افتراضيًا
                const defaultColorId = $('input[name="color_id"]:checked').val();
                fetchSizes(defaultColorId);
            }

            // عند اختيار لون، تحديث المقاسات
            $(document).on('change', 'input[name="color_id"]', function() {
                const colorId = $(this).val();
                fetchSizes(colorId);
            });

            // عند اختيار مقاس أو لون
            $(document).on('change', 'input[name="size_id"], input[name="color_id"]', function() {
                const colorId = $('input[name="color_id"]:checked').val() || null;
                const sizeId = $('input[name="size_id"]:checked').val() || null;

                fetchStock(productId, colorId, sizeId);
            });

            // التحكم في الكمية



            // trigger initial stock load
            setTimeout(function() {
                const colorId = $('input[name="color_id"]:checked').val() || null;
                const sizeId = $('input[name="size_id"]:checked').val() || null;
                fetchStock(productId, colorId, sizeId);
            }, 300);
        };

        // Initialize the scripts when the document is ready
        $(document).ready(function() {
            initializeProductModalScripts();
        });
    </script>
    <script>
        $(document).on('click', '#add-to-cart-btn', function(e) {
            e.preventDefault();

            const productId = $('input[name="product_id"]').val();
            const quantity = $('.quantity-input').val();
            const colorId = $('input[name="color_id"]:checked').val();
            const sizeId = $('input[name="size_id"]:checked').val();

            console.log({
                productId,
                quantity,
                colorId,
                sizeId
            }); // تحقق من القيم

            if (!productId || !quantity) {
                alert("يجب تحديد المنتج والكمية.");
                return;
            }

            $.ajax({
                url: '{{ route('cart.add') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity,
                    color_id: colorId,
                    size_id: sizeId,
                },
                beforeSend: function() {
                    $('#add-to-cart-btn').html(
                        '<span class="spinner-border spinner-border-sm"></span> {{ __('جاري الإضافة...') }}'
                    ).prop('disabled', true);
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تمت الإضافة',
                        text: response.message || 'تم إضافة المنتج إلى السلة بنجاح!',
                    });

                    if (response.cart_count !== undefined) {
                        $('#cart-count').text(response.cart_count);
                    }

                    $.get('/cart/mini', function(html) {
                        $('.cart-menu').html(html);
                    });

                    $('#add-to-cart-btn').html('{{ __('أضف إلى السلة') }}').prop('disabled', false);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: xhr.responseJSON?.message || 'فشل في إضافة المنتج إلى السلة!',
                    });

                    $('#add-to-cart-btn').html('{{ __('أضف إلى السلة') }}').prop('disabled', false);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // دالة لاستخراج قيمة المخزون من العنصر
            function getCurrentStock() {
                const stockElement = document.getElementById('stock-display');
                if (!stockElement) return 100; // قيمة افتراضية إذا لم يوجد العنصر

                // استخراج الرقم من النص (مثال: "الكمية المتوفرة: 5" → 5)
                const stockText = stockElement.textContent || stockElement.innerText;
                const stockValue = parseInt(stockText.replace(/[^0-9]/g, ''));
                return isNaN(stockValue) ? 100 : stockValue; // قيمة افتراضية إذا لم يتم العثور على رقم
            }

            // دالة للتحكم في الكمية
            function handleQuantity(button, direction) {
                const counter = button.closest('.quantity-counter');
                const input = counter.querySelector('.quantity-input');
                let value = parseInt(input.value) || 1;
                const min = parseInt(input.getAttribute('min')) || 1;
                const max = getCurrentStock(); // الحصول على المخزون الحالي

                if (direction === 'plus') {
                    value = Math.min(value + 1, max);
                } else {
                    value = Math.max(value - 1, min);
                }

                input.value = value;
                updateButtonStates(input);

                // تشغيل حدث التغيير
                input.dispatchEvent(new Event('change'));
            }

            // دالة لتحديث حالة الأزرار
            function updateButtonStates(input) {
                const value = parseInt(input.value) || 1;
                const min = parseInt(input.getAttribute('min')) || 1;
                const max = getCurrentStock();

                const counter = input.closest('.quantity-counter');
                counter.querySelector('.minus').classList.toggle('disabled', value <= min);
                counter.querySelector('.plus').classList.toggle('disabled', value >= max);
            }

            // أحداث النقر على الأزرار
            $(document).on('click', '.quantity-btn:not(.disabled)', function() {
                const direction = $(this).hasClass('plus') ? 'plus' : 'minus';
                handleQuantity(this, direction);
            });

            // التحقق من صحة الإدخال اليدوي
            $(document).on('change input', '.quantity-input', function() {
                let value = parseInt(this.value) || 1;
                const min = parseInt(this.getAttribute('min')) || 1;
                const max = getCurrentStock();

                if (isNaN(value) || value < min) {
                    this.value = min;
                } else if (value > max) {
                    this.value = max;
                }

                updateButtonStates(this);
            });

            // تحديث الحالة الأولية للأزرار
            $('.quantity-input').each(function() {
                updateButtonStates(this);
            });
        });
       $('#reviewForm').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const submitBtn = $('#submitReview');
    const spinner = submitBtn.find('.spinner-border');
    const btnText = submitBtn.find('.btn-text');

    // إظهار اللودر
    spinner.removeClass('d-none');
    btnText.text('{{ __("جارٍ الإرسال...") }}');

    $.ajax({
        type: 'POST',
        url: '{{ route('review.submit') }}',
        data: form.serialize(),
        success: function(response) {
            // إخفاء اللودر
            spinner.addClass('d-none');
            btnText.text('{{ __("إرسال التقييم") }}');

            // عرض رسالة نجاح
            Swal.fire({
        icon: 'success',
        title: '{{ __("تم إرسال التقييم بنجاح") }}',
        showConfirmButton: false,
    }).then(() => {
        location.reload(); // 🔁 إعادة تحميل الصفحة بعد إغلاق التنبيه
    });

            // إعادة ضبط النموذج وإغلاق المودال
            $('#reviewForm')[0].reset();
            $('#reviewModal').modal('hide');
        },
        error: function(xhr) {
            spinner.addClass('d-none');
            btnText.text('{{ __("إرسال التقييم") }}');

            let errors = xhr.responseJSON?.errors;
            if (errors) {
                let errorMsg = '';
                for (let key in errors) {
                    errorMsg += errors[key][0] + "<br>";
                }

                Swal.fire({
                    icon: 'error',
                    title: '{{ __("حدثت أخطاء في النموذج") }}',
                    html: errorMsg,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("حدث خطأ أثناء الإرسال") }}',
                    text: '{{ __("يرجى المحاولة مرة أخرى لاحقاً.") }}',
                });
            }
        }
    });
});

    </script>

@endsection
