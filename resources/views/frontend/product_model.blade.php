<div class="modal-body">
    @php
        $colors = App\Models\ProductAttribute::where('type', 'color')->get();
        $sizes = App\Models\ProductAttribute::where('type', 'size')->get();

        // جميع المتغيرات (لون + مقاس + مخزون)
        $variations = $product
            ->variations()
            ->with(['colorAttribute', 'sizeAttribute'])
            ->where('stock', '>', 0)
            ->get();
    @endphp
    <div class="close-btn" data-bs-dismiss="modal">
    </div>
    <div class="shop-details-top-section">
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="shop-details-img">
                    <div class="tab-content" id="view-tabContent">
                        @foreach ($product->images as $index => $image)
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                id="view-pills-img{{ $index }}" role="tabpanel">
                                <div class="shop-details-tab-img">
                                    <img src="{{ Storage::url($image->image) }}" alt="">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="nav nav-pills" id="view-tab" role="tablist" aria-orientation="vertical">
                        @foreach ($product->images as $index => $image)
                            <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                id="view-pills-img{{ $index }}-tab" data-bs-toggle="pill"
                                data-bs-target="#view-pills-img{{ $index }}" type="button" role="tab"
                                aria-controls="view-pills-img{{ $index }}"
                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                <img src="{{ Storage::url($image->image) }}" alt="">
                            </button>
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
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p>(50 customer review)</p>
                        </div>
                    </div>
                    <p>{!! $product->short_description !!}</p>
                    <div class="price-area">
                        <p class="price">{{ $product->price }} ₪</p>
                    </div>
                    <p class="stock-available text-success mt-2" data-stock-label="{{ __('الكمية المتوفرة') }}"></p>

                    <div class="quantity-color-area">

                        <div class="quantity-color">
                            <h6 class="widget-title">{{ __('الكمية') }}</h6>
                            <div class="quantity-counter">
                                <a type="button" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                <input name="quantity" type="number" min="1" class="quantity__input"
                                    value="1">
                                <a type="button" class="quantity__plus"><i class='bx bx-plus'></i></a>
                                <input type="hidden" id="product_id" value="{{ $product->id }}">

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
                                <span>{{__('نفذ من المخزون')}}</span>
                            </div>
                        @else
                            <a id="add-to-cart-btn-checkout" class="primary-btn1 hover-btn3">{{ __('اشتري الآن') }}</a>
                            <a id="add-to-cart-btn"
                                class="primary-btn1 style-3 hover-btn4">{{ __('أضف الى السلة') }}</a>
                        @endif
                    </div>
                    {{-- <div class="product-info">
                        <ul class="product-info-list">
                            <li> <span>SKU:</span> 9852410</li>
                            <li> <span>Brand:</span> <a href="shop-4-columns.html">Chanel</a></li>
                            <li> <span>Category:</span> <a href="shop-slider.html">Body</a>, <a
                                    href="shop-slider.html">Face</a></li>
                        </ul>
                    </div> --}}
                    <div class="payment-method">
                        <h6>{{ __('عملية دفع آمنة مضمونة') }}</h6>
                        <ul class="payment-card-list">
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img1.svg') }}" alt="">
                            </li>
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img2.svg') }}" alt="">
                            </li>
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img3.svg') }}" alt="">
                            </li>
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img4.svg') }}" alt="">
                            </li>
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img5.svg') }}" alt="">
                            </li>
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img6.svg') }}"
                                    alt="">
                            </li>
                            <li><img src="{{ asset('front/assets/img/inner-page/payment-img7.svg') }}"
                                    alt="">
                            </li>
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
                                    href="#">{{ __('شحن وإرجاع') }}</a></p>
                        </li>
                    </ul>
                    <div class="compare-wishlist-area">
                        <ul>
                            <li>
                                <button class="add-to-wishlist btn  {{ $product->isInWishlist() ? 'active' : '' }}"
                                    data-product-id="{{ $product->id }}" title="{{ __('أضف إلى المفضلة') }}">
                                    <i class="fa fa-heart"></i>
                                    <span class="wishlist-text">{{ __('أضف إلى المفضلة') }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex align-items-center gap-2">
    <div class="spinner-border spinner-border-sm text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <span>{{ __('جاري تحميل الكمية...') }}</span>
</div>
