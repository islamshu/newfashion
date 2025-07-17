<div class="cart-body" style="max-height: 320px; overflow-y: auto;">
    <ul>
        @forelse ($cart as $index=>$item)
            @php
                $product = \App\Models\Product::find($item['product_id']);
                $color = $item['color_id'] ? \App\Models\ProductAttribute::find($item['color_id']) : null;
                $size = $item['size_id'] ? \App\Models\ProductAttribute::find($item['size_id']) : null;
                $price = $product->price;
                $totalItemPrice = $price * $item['quantity'];
            @endphp
            <li class="single-item border-bottom py-2">
                <div class="item-area d-flex">
                    <div class="item-img me-2">
                        <img src="{{ Storage::url($product->thumbnails()->first()->image) }}" alt="{{ $product->name }}"
                            width="60" height="60">
                    </div>
                    <div class="content-and-quantity flex-grow-1">
                        <div class="content">
                            <div class="price-and-btn d-flex align-items-center justify-content-between">
                                <span>₪{{ number_format($totalItemPrice, 2) }}</span>
                                <button class="close-btn remove-item" data-id="{{ $index }}">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <p class="mb-1"><a href="#" class="text-dark">{{ $product->name }}</a></p>
                            <small class="text-muted d-block">
                                @if ($color)
                                    <span>{{ __('اللون') }}:
                                        <span
                                            style="display:inline-block;width:15px;height:15px;background:{{ $color->code }};border-radius:4px;border:1px solid #ccc;"></span>
                                    </span>
                                @endif
                                @if ($size)
                                    <span class="ms-2">{{ __('المقاس') }}: {{ $size->value }}</span>
                                @endif
                            </small>
                        </div>
                        <div class="quantity-area mt-1">
                            <div class="quantity">
                                <span>{{ __('الكمية') }}: {{ $item['quantity'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="text-center py-3">{{ __('السلة فارغة') }}</li>
        @endforelse
    </ul>
</div>
    <div class="cart-footer p-3 border-top">
        <div class="pricing-area">
            <ul class="mb-2">
                <li class="d-flex justify-content-between">
                    <span>{{ __('المجموع الفرعي') }}</span><span>₪{{ number_format($subTotal, 2) }}</span></li>
            </ul>
            <ul class="total fw-bold">
                <li class="d-flex justify-content-between">
                    <span>{{ __('الإجمالي') }}</span><span>₪{{ number_format($subTotal, 2) }}</span></li>
            </ul>
        </div>
        @if ($cart)

        <div class="footer-button mt-3">
            <ul class="list-unstyled d-grid gap-2">
                <li><a class="primary-btn1 hover-btn4 btn btn-outline-primary btn-sm w-100"
                        href="{{ route('products.all') }}">{{ __('متابعة التسوق') }}</a></li>
                <li><a class="primary-btn1 hover-btn3 btn btn-primary btn-sm w-100"
                        href="{{ route('checkout') }}">{{ __('إتمام الشراء') }}</a></li>
            </ul>
        </div>
        @endif

    </div>
